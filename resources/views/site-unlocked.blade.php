<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title>Site is Live! — {{ $siteName }}</title>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden}

body{
    min-height:100vh;
    background:radial-gradient(ellipse at 50% 40%, #0a1628 0%, #050010 100%);
    font-family:'Inter',sans-serif;
    color:#fff;
    display:flex;align-items:center;justify-content:center;
    position:relative;
}

/* ── Confetti ───────────────────────────────── */
#confetti-canvas{
    position:fixed;inset:0;pointer-events:none;z-index:10;
}

/* ── Burst ring ─────────────────────────────── */
@keyframes burst-ring{
    0%{transform:translate(-50%,-50%) scale(0);opacity:.9}
    100%{transform:translate(-50%,-50%) scale(3.5);opacity:0}
}
.burst{
    position:fixed;top:50%;left:50%;
    width:300px;height:300px;border-radius:50%;
    border:3px solid rgba(255,210,50,.7);
    animation:burst-ring 1.4s ease-out forwards;
    pointer-events:none;z-index:5;
}
.burst-2{animation-delay:.25s;border-color:rgba(100,220,120,.6);animation-duration:1.7s}
.burst-3{animation-delay:.5s;border-color:rgba(80,160,255,.5);animation-duration:2s}

/* ── Stars ──────────────────────────────────── */
.stars-layer{position:fixed;inset:0;pointer-events:none;z-index:0;}
.star{position:absolute;border-radius:50%;background:#fff;animation:twinkle var(--dur,3s) ease-in-out infinite var(--delay,0s);}
@keyframes twinkle{0%,100%{opacity:.1}50%{opacity:.9}}

/* ── Card ───────────────────────────────────── */
@keyframes card-in{
    0%{opacity:0;transform:scale(.6) translateY(40px)}
    70%{transform:scale(1.04) translateY(-6px)}
    100%{opacity:1;transform:scale(1) translateY(0)}
}
.card{
    position:relative;z-index:20;
    text-align:center;
    padding:56px 44px 48px;
    background:rgba(255,255,255,.04);
    backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,.1);
    border-radius:28px;
    max-width:480px;width:90%;
    box-shadow:0 32px 80px rgba(0,0,0,.6), inset 0 1px 0 rgba(255,255,255,.08);
    animation:card-in .8s cubic-bezier(.34,1.56,.64,1) .1s both;
}

/* ── Checkmark ──────────────────────────────── */
@keyframes check-pop{
    0%{transform:scale(0) rotate(-30deg);opacity:0}
    60%{transform:scale(1.2) rotate(5deg)}
    100%{transform:scale(1) rotate(0);opacity:1}
}
.check-wrap{
    width:88px;height:88px;border-radius:50%;
    background:linear-gradient(135deg,#16a34a,#22c55e);
    display:flex;align-items:center;justify-content:center;
    margin:0 auto 24px;
    box-shadow:0 0 0 16px rgba(34,197,94,.12), 0 0 0 32px rgba(34,197,94,.06);
    animation:check-pop .7s cubic-bezier(.34,1.56,.64,1) .4s both;
}
.check-wrap i{font-size:2.2rem;color:#fff;}

/* ── Title ──────────────────────────────────── */
@keyframes shine{
    0%{background-position:-200% center}
    100%{background-position:200% center}
}
.live-title{
    font-family:'Cinzel',serif;font-weight:900;
    font-size:clamp(1.6rem,5vw,2.4rem);
    background:linear-gradient(90deg,#fbbf24 0%,#fff7d6 30%,#ffd700 50%,#fff7d6 70%,#fbbf24 100%);
    background-size:200% auto;
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    animation:shine 3s linear infinite, card-in .8s cubic-bezier(.34,1.56,.64,1) .5s both;
    margin-bottom:10px;
}

/* ── Sub text ───────────────────────────────── */
@keyframes fade-in{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.sub-text{color:rgba(200,220,255,.7);font-size:.95rem;line-height:1.7;animation:fade-in .6s ease .8s both;margin-bottom:32px;}

/* ── Countdown ──────────────────────────────── */
.countdown-wrap{
    animation:fade-in .6s ease 1s both;
}
.countdown-label{font-size:.75rem;letter-spacing:.12em;text-transform:uppercase;color:rgba(180,200,255,.5);margin-bottom:8px;}
.countdown-ring{
    position:relative;width:80px;height:80px;margin:0 auto 12px;
}
.countdown-ring svg{transform:rotate(-90deg);}
.ring-bg{fill:none;stroke:rgba(255,255,255,.08);stroke-width:5;}
.ring-fill{
    fill:none;stroke:url(#ringGrad);stroke-width:5;
    stroke-linecap:round;
    stroke-dasharray:220;
    stroke-dashoffset:0;
    transition:stroke-dashoffset 1s linear;
}
.countdown-num{
    position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
    font-size:1.8rem;font-weight:700;color:#fff;font-family:'Cinzel',serif;
}
.redirect-msg{font-size:.8rem;color:rgba(200,220,255,.5);}

/* ── Progress bar ───────────────────────────── */
.prog-bar-wrap{margin-top:20px;height:4px;background:rgba(255,255,255,.08);border-radius:4px;overflow:hidden;}
.prog-bar{height:100%;border-radius:4px;background:linear-gradient(90deg,#22c55e,#fbbf24);width:100%;transition:width 1s linear;}

/* ── Sparkle dots ───────────────────────────── */
@keyframes sparkle-fly{
    0%{opacity:1;transform:translate(0,0) scale(1)}
    100%{opacity:0;transform:translate(var(--tx),var(--ty)) scale(0)}
}
.sparkle{
    position:fixed;width:8px;height:8px;border-radius:50%;
    pointer-events:none;z-index:15;
    animation:sparkle-fly 1.2s ease-out var(--delay,.1s) forwards;
}
</style>
</head>
<body>

<canvas id="confetti-canvas"></canvas>
<div class="stars-layer" id="stars"></div>
<div class="burst"></div>
<div class="burst burst-2"></div>
<div class="burst burst-3"></div>

<div class="card">

    <div class="check-wrap">
        <i class="fas fa-check"></i>
    </div>

    <h1 class="live-title">Site is Now Live!</h1>

    <p class="sub-text">
        <strong style="color:#fff;">{{ $siteName }}</strong> has been successfully unlocked.<br>
        Your website is now accessible to all visitors.
    </p>

    <div class="countdown-wrap">
        <p class="countdown-label">Redirecting to home in</p>
        <div class="countdown-ring">
            <svg viewBox="0 0 80 80" width="80" height="80">
                <defs>
                    <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#22c55e"/>
                        <stop offset="100%" stop-color="#fbbf24"/>
                    </linearGradient>
                </defs>
                <circle class="ring-bg" cx="40" cy="40" r="35"/>
                <circle class="ring-fill" id="ring-fill" cx="40" cy="40" r="35"/>
            </svg>
            <div class="countdown-num" id="count-num">5</div>
        </div>
        <p class="redirect-msg">Taking you to the home page&hellip;</p>
        <div class="prog-bar-wrap">
            <div class="prog-bar" id="prog-bar"></div>
        </div>
    </div>

</div>

<script>
// ── Stars ────────────────────────────────────
(function(){
    var layer=document.getElementById('stars');
    for(var i=0;i<80;i++){
        var s=document.createElement('div');s.className='star';
        var sz=(Math.random()*2+.5)+'px';
        s.style.cssText='width:'+sz+';height:'+sz+';top:'+(Math.random()*100)+'%;left:'+(Math.random()*100)+'%;--dur:'+(Math.random()*4+2)+'s;--delay:-'+(Math.random()*5)+'s';
        layer.appendChild(s);
    }
})();

// ── Sparkles from center ─────────────────────
(function(){
    var colors=['#fbbf24','#22c55e','#60a5fa','#f472b6','#a78bfa'];
    for(var i=0;i<24;i++){
        var el=document.createElement('div');
        el.className='sparkle';
        var angle=Math.random()*360;
        var dist=Math.random()*220+80;
        el.style.cssText=[
            'background:'+colors[Math.floor(Math.random()*colors.length)],
            'left:50%','top:50%',
            '--tx:'+(Math.cos(angle*Math.PI/180)*dist)+'px',
            '--ty:'+(Math.sin(angle*Math.PI/180)*dist)+'px',
            '--delay:'+(Math.random()*.6)+'s'
        ].join(';');
        document.body.appendChild(el);
    }
})();

// ── Confetti ─────────────────────────────────
(function(){
    var canvas=document.getElementById('confetti-canvas');
    var ctx=canvas.getContext('2d');
    canvas.width=window.innerWidth;
    canvas.height=window.innerHeight;

    var pieces=[];
    var colors=['#fbbf24','#22c55e','#60a5fa','#f472b6','#a78bfa','#fb923c','#fff'];

    function Piece(){
        this.x=Math.random()*canvas.width;
        this.y=Math.random()*canvas.height-canvas.height;
        this.w=Math.random()*10+5;
        this.h=Math.random()*5+3;
        this.color=colors[Math.floor(Math.random()*colors.length)];
        this.rot=Math.random()*360;
        this.vx=(Math.random()-0.5)*3;
        this.vy=Math.random()*4+2;
        this.vr=Math.random()*6-3;
        this.opacity=1;
    }

    for(var i=0;i<140;i++) pieces.push(new Piece());

    var start=null;
    var DURATION=5000;

    function draw(ts){
        if(!start) start=ts;
        var elapsed=ts-start;
        ctx.clearRect(0,0,canvas.width,canvas.height);

        pieces.forEach(function(p){
            p.x+=p.vx; p.y+=p.vy; p.rot+=p.vr;
            if(elapsed>3000) p.opacity=Math.max(0,p.opacity-0.012);
            ctx.save();
            ctx.translate(p.x,p.y);
            ctx.rotate(p.rot*Math.PI/180);
            ctx.globalAlpha=p.opacity;
            ctx.fillStyle=p.color;
            ctx.fillRect(-p.w/2,-p.h/2,p.w,p.h);
            ctx.restore();
        });

        if(elapsed<DURATION) requestAnimationFrame(draw);
        else ctx.clearRect(0,0,canvas.width,canvas.height);
    }
    requestAnimationFrame(draw);
})();

// ── Countdown + redirect ──────────────────────
(function(){
    var total=5;
    var remaining=total;
    var numEl=document.getElementById('count-num');
    var ringEl=document.getElementById('ring-fill');
    var progEl=document.getElementById('prog-bar');
    var circumference=2*Math.PI*35; // ~220

    function update(){
        numEl.textContent=remaining;
        var pct=(remaining/total);
        ringEl.style.strokeDashoffset=(circumference*(1-pct));
        progEl.style.width=(pct*100)+'%';
    }

    update();

    var interval=setInterval(function(){
        remaining--;
        update();
        if(remaining<=0){
            clearInterval(interval);
            setTimeout(function(){ window.location.href='{{ route('home') }}'; }, 600);
        }
    },1000);
})();
</script>
</body>
</html>
