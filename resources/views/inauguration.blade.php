<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title>Grand Inauguration — {{ $siteName }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow-x:hidden}

body{
    min-height:100vh;
    background: radial-gradient(ellipse at 20% 50%, #1a0533 0%, #0d001f 40%, #050010 100%);
    font-family:'Inter',sans-serif;
    color:#fff;
    position:relative;
}

/* ── Particle stars ─────────────────────────── */
.stars-layer{
    position:fixed;inset:0;pointer-events:none;z-index:0;overflow:hidden;
}
.star{
    position:absolute;border-radius:50%;background:#fff;
    animation:twinkle var(--dur,3s) ease-in-out infinite var(--delay,0s);
}
@keyframes twinkle{
    0%,100%{opacity:0.1;transform:scale(1)}
    50%{opacity:1;transform:scale(1.4)}
}

/* ── Floating orbs ──────────────────────────── */
.orb{
    position:fixed;border-radius:50%;filter:blur(80px);
    pointer-events:none;z-index:0;animation:orb-drift 12s ease-in-out infinite;
}
.orb-1{width:400px;height:400px;background:rgba(120,40,200,.35);top:-100px;left:-100px;animation-delay:0s}
.orb-2{width:350px;height:350px;background:rgba(200,80,20,.25);bottom:-80px;right:-80px;animation-delay:-5s}
.orb-3{width:250px;height:250px;background:rgba(50,80,220,.3);top:40%;left:60%;animation-delay:-8s}
@keyframes orb-drift{
    0%,100%{transform:translate(0,0) scale(1)}
    33%{transform:translate(30px,-40px) scale(1.1)}
    66%{transform:translate(-20px,30px) scale(.9)}
}

/* ── Gold shimmer border ─────────────────────── */
@keyframes border-spin{
    0%{background-position:0% 50%}
    100%{background-position:200% 50%}
}
.gold-border{
    border-radius:20px;
    padding:3px;
    background:linear-gradient(90deg,#b8860b,#ffd700,#daa520,#ffe066,#b8860b,#ffd700);
    background-size:200% 100%;
    animation:border-spin 3s linear infinite;
}

/* ── Glow pulse on image ─────────────────────── */
@keyframes glow-pulse{
    0%,100%{box-shadow:0 0 30px 8px rgba(218,165,32,.3), 0 0 60px 20px rgba(180,100,0,.15)}
    50%{box-shadow:0 0 50px 16px rgba(255,215,0,.55), 0 0 100px 40px rgba(200,120,0,.25)}
}
.img-glow{animation:glow-pulse 3s ease-in-out infinite;border-radius:16px;}

/* ── Title shine ────────────────────────────── */
@keyframes shine{
    0%{background-position:-200% center}
    100%{background-position:200% center}
}
.shine-text{
    background:linear-gradient(90deg,#daa520 0%,#fff8e7 30%,#ffd700 50%,#fff8e7 70%,#daa520 100%);
    background-size:200% auto;
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    animation:shine 4s linear infinite;
    font-family:'Cinzel',serif;
}

/* ── Float up-down ──────────────────────────── */
@keyframes float{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-10px)}
}
.float-anim{animation:float 4s ease-in-out infinite}

/* ── Reveal fade-up ─────────────────────────── */
@keyframes fadeUp{
    from{opacity:0;transform:translateY(30px)}
    to{opacity:1;transform:translateY(0)}
}
.fade-up{animation:fadeUp .8s ease both}
.fade-up-d1{animation-delay:.2s;opacity:0;animation-fill-mode:both}
.fade-up-d2{animation-delay:.45s;opacity:0;animation-fill-mode:both}
.fade-up-d3{animation-delay:.7s;opacity:0;animation-fill-mode:both}
.fade-up-d4{animation-delay:.95s;opacity:0;animation-fill-mode:both}
.fade-up-d5{animation-delay:1.2s;opacity:0;animation-fill-mode:both}

/* ── Unlock button ──────────────────────────── */
@keyframes btn-glow{
    0%,100%{box-shadow:0 0 0 0 rgba(255,160,10,.4)}
    50%{box-shadow:0 0 20px 8px rgba(255,160,10,.2)}
}
.unlock-btn{
    display:inline-flex;align-items:center;gap:10px;
    background:linear-gradient(135deg,#7c2d12,#9a3412,#b45309);
    color:#fff;font-weight:700;font-size:.85rem;
    padding:12px 28px;border-radius:50px;
    border:1.5px solid rgba(255,200,80,.4);
    cursor:pointer;transition:all .3s;
    animation:btn-glow 2.5s ease-in-out infinite;
    text-decoration:none;
    letter-spacing:.04em;
}
.unlock-btn:hover{
    background:linear-gradient(135deg,#9a3412,#b45309,#d97706);
    transform:translateY(-2px);
    box-shadow:0 8px 30px rgba(180,83,9,.5);
}

/* ── Divider ornament ───────────────────────── */
.ornament{
    display:flex;align-items:center;gap:12px;justify-content:center;
    color:rgba(218,165,32,.6);font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;
}
.ornament::before,.ornament::after{
    content:'';flex:1;max-width:100px;height:1px;
    background:linear-gradient(90deg,transparent,rgba(218,165,32,.5),transparent);
}

/* ── Layout ─────────────────────────────────── */
.page-wrap{
    position:relative;z-index:1;
    min-height:100vh;
    display:flex;flex-direction:column;align-items:center;justify-content:center;
    padding:40px 20px;
    gap:0;
}
.content-card{
    width:100%;max-width:720px;
    text-align:center;
}
</style>
</head>
<body>

{{-- Starfield --}}
<div class="stars-layer" id="stars"></div>

{{-- Floating orbs --}}
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="page-wrap">
<div class="content-card">

    {{-- Eyebrow --}}
    <div class="fade-up fade-up-d1">
        <div class="ornament mb-4">
            <i class="fas fa-star"></i>
            <span>Grand Inauguration</span>
            <i class="fas fa-star"></i>
        </div>
    </div>

    {{-- Site name --}}
    <div class="fade-up fade-up-d2 mb-2">
        <h1 class="shine-text" style="font-size:clamp(1.6rem,5vw,2.8rem);line-height:1.2;font-weight:900;letter-spacing:.03em;">
            {{ $siteName }}
        </h1>
    </div>

    <div class="fade-up fade-up-d2 mb-8">
        <p style="color:rgba(200,180,255,.7);font-size:.9rem;letter-spacing:.06em;text-transform:uppercase;">
            Charitable Trust &nbsp;·&nbsp; Kolhapur
        </p>
    </div>

    {{-- Image --}}
    @if($lockImage)
    <div class="fade-up fade-up-d3 float-anim mb-8" style="margin-left:auto;margin-right:auto;max-width:500px;">
        <div class="gold-border">
            <div class="img-glow" style="border-radius:17px;overflow:hidden;background:#000;">
                <img src="{{ str_starts_with($lockImage,'http') ? $lockImage : asset('storage/'.$lockImage) }}"
                     alt="Inauguration — {{ $siteName }}"
                     style="width:100%;height:auto;display:block;border-radius:17px;">
            </div>
        </div>
    </div>
    @else
    <div class="fade-up fade-up-d3 mb-8" style="padding:60px 0;">
        <div style="width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.06);border:2px solid rgba(218,165,32,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i class="fas fa-landmark" style="font-size:2.5rem;color:rgba(218,165,32,.7);"></i>
        </div>
        <p style="color:rgba(200,180,255,.5);font-size:.9rem;">Inauguration details coming soon&hellip;</p>
    </div>
    @endif

    {{-- Message --}}
    <div class="fade-up fade-up-d4 mb-8">
        <p style="color:rgba(220,200,255,.75);font-size:.95rem;line-height:1.8;max-width:500px;margin:0 auto;">
            We are undergoing an exciting new phase. Our website will be fully live shortly.
            Thank you for your patience and continued support.
        </p>
    </div>

    {{-- Ornament --}}
    <div class="fade-up fade-up-d4 mb-8">
        <div class="ornament">
            <span>Seva &nbsp;·&nbsp; Compassion &nbsp;·&nbsp; Progress</span>
        </div>
    </div>

    {{-- Unlock button --}}
    <div class="fade-up fade-up-d5">
        <form method="POST" action="{{ route('site.unlock') }}">
            @csrf
            <button type="submit" class="unlock-btn">
                <i class="fas fa-unlock-alt"></i>
                Unlock Site
            </button>
        </form>
        <p style="color:rgba(255,255,255,.2);font-size:.72rem;margin-top:10px;">Admin only</p>
    </div>

</div>
</div>

<script>
// Generate random stars
(function(){
    var layer = document.getElementById('stars');
    for(var i=0;i<120;i++){
        var s=document.createElement('div');
        s.className='star';
        var size=(Math.random()*2.5+.5)+'px';
        s.style.cssText=[
            'width:'+size,'height:'+size,
            'top:'+(Math.random()*100)+'%',
            'left:'+(Math.random()*100)+'%',
            '--dur:'+(Math.random()*4+2)+'s',
            '--delay:-'+(Math.random()*5)+'s',
            'opacity:'+(Math.random()*.5+.1)
        ].join(';');
        layer.appendChild(s);
    }
})();
</script>
</body>
</html>
