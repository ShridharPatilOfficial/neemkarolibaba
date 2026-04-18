<?php

namespace App\Http\Controllers\Admin\Concerns;

trait ManagesSortOrder
{
    /**
     * Get the next available sort_order (max + 1) for a model,
     * optionally scoped to extra conditions (e.g. post_year).
     */
    protected function nextSortOrder(string $modelClass, array $scope = []): int
    {
        $q = $modelClass::query();
        foreach ($scope as $col => $val) {
            $q->where($col, $val);
        }
        return (int) ($q->max('sort_order') ?? -1) + 1;
    }

    /**
     * After saving a record, if another record already occupies the same
     * sort_order, swap them: the conflicting record gets $freeOrder.
     *
     * For create  → $freeOrder = nextSortOrder() calculated before the insert.
     * For update  → $freeOrder = the item's OLD sort_order before the update.
     */
    protected function swapSortOrderIfConflict(
        string $modelClass,
        int    $savedId,
        int    $desiredOrder,
        int    $freeOrder,
        array  $scope = []
    ): void {
        if ($desiredOrder === $freeOrder) {
            return; // no conflict possible
        }
        $q = $modelClass::where('sort_order', $desiredOrder)
                        ->where('id', '!=', $savedId);
        foreach ($scope as $col => $val) {
            $q->where($col, $val);
        }
        $conflict = $q->first();
        if ($conflict) {
            $conflict->update(['sort_order' => $freeOrder]);
        }
    }
}
