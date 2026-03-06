<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CODE GALAXY // SYSTEM ONLINE</title>
    <meta name="description" content="Code Galaxy — Holographic Code Snippet Manager">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/galaxy.css') }}">
</head>

<body>
    <canvas id="voidCanvas"></canvas>
    <div class="film-grain"></div>
    <div class="scan-lines"></div>
    <div class="scan-beam"></div>
    <div class="fog-orb fog-1"></div>
    <div class="fog-orb fog-2"></div>
    <div class="fog-orb fog-3"></div>

    <!--  for  the command bar  -->
    @php
    $totalSnippets = 0; $langMap = []; $catCount = 0;
    foreach($groupedCategories as $cats) { foreach($cats as $cat) { $catCount++; $totalSnippets += $cat->snippets->count(); foreach($cat->snippets as $s) { $langMap[$s->language] = true; } } }
    @endphp
    <nav class="cmd" id="cmdBar">
        <div class="cmd__inner">
            <div class="cmd__logo">
                <div class="cmd__diamond"></div><span>CODE GALAXY</span>
            </div>
            <div class="cmd__meta">
                <span>NODES:{{ $totalSnippets }}</span>
                <span>LANGS:{{ count($langMap) }}</span>
                <span class="cmd__status"><span class="cmd__dot"></span>ONLINE</span>
            </div>
        </div>
    </nav>

    <!-- hero sections -->
    <header class="hero">
        <div class="hero__tag"><span>◇</span> HOLOGRAPHIC SNIPPET INTERFACE</div>
        <h1 class="hero__title">
            <span class="glitch" data-text="CODE">CODE</span><br>
            <span class="glitch glitch--cyan" data-text="GALAXY">GALAXY</span>
        </h1>
        <p class="hero__sub">── CLASSIFIED DATA ARCHIVE ──</p>

        <div class="stats">
            <div class="stat">
                <div class="stat__val">{{ $totalSnippets }}</div>
                <div class="stat__lbl">FRAGMENTS</div>
            </div>
            <div class="stat">
                <div class="stat__val">{{ count($langMap) }}</div>
                <div class="stat__lbl">PROTOCOLS</div>
            </div>
            <div class="stat">
                <div class="stat__val">{{ $groupedCategories->count() }}</div>
                <div class="stat__lbl">SECTORS</div>
            </div>
            <div class="stat">
                <div class="stat__val">{{ $catCount }}</div>
                <div class="stat__lbl">CLUSTERS</div>
            </div>
        </div>

        <div class="search">
            <div class="search__frame" id="searchFrame">
                <div class="search__bar"><span class="search__prompt">⟩</span><span>QUERY.INTERFACE</span><span class="search__esc">ESC</span></div>
                <input type="text" id="searchInput" class="search__input" placeholder="ENTER SEARCH VECTOR..." autocomplete="off" spellcheck="false">
                <div class="search__glow"></div>
            </div>
        </div>

        <div class="filters" id="filters">
            <button class="fbtn active" data-filter="all">◆ ALL</button>
            @foreach($groupedCategories->keys() as $type)
            <button class="fbtn" data-filter="{{ $type }}">△ {{ strtoupper($type) }}</button>
            @endforeach
        </div>
    </header>

    <!--  for the shards -->
    <main class="main">
        @foreach($groupedCategories as $type => $categories)
        <section class="sector reveal" data-type="{{ $type }}">
            <div class="sector__axis">
                <div class="sector__line"></div>
                <span class="sector__title">SECTOR::{{ strtoupper($type) }}</span>
                <span class="sector__count">{{ $categories->sum(fn($c) => $c->snippets->count()) }}</span>
                <div class="sector__line sector__line--r"></div>
            </div>
            <div class="shards">
                @foreach($categories as $category)
                @foreach($category->snippets as $snippet)
                @php
                $morse = ''; $ch = str_split(strtoupper($snippet->title));
                foreach(array_slice($ch,0,8) as $c) { $morse .= (ord($c)%2===0)?'─ ':'• '; }
                $bars = []; for($i=0;$i<8;$i++) $bars[]=rand(3,14);
                    $ext=match($snippet->language){'javascript'=>'js','python'=>'py',default=>$snippet->language};
                    $hue = match($snippet->language){'php'=>270,'javascript'=>50,'sql'=>185,'css'=>215,'python'=>155,default=>200};
                    @endphp
                    <article class="shard reveal" data-title="{{ $snippet->title }}" data-desc="{{ $snippet->description }}" data-lang="{{ $snippet->language }}" style="--hue:{{ $hue }}">
                        <!-- Overlays -->
                        <div class="shard__scan"></div>
                        <div class="shard__refract"></div>
                        <div class="shard__schematic"></div>

                        <!-- Collapsed preview  -->
                        <div class="shard__preview">
                            <div class="shard__head">
                                <div class="shard__id">
                                    <div class="shard__icon">
                                        @if($category->icon)<img src="{{ $category->icon }}" alt="">@else<i class="fa-solid fa-terminal"></i>@endif
                                    </div>
                                    <div>
                                        <h3 class="shard__title">{{ $snippet->title }}</h3><span class="shard__cat">{{ strtoupper($category->name) }}</span>
                                    </div>
                                </div>
                                <div class="shard__tools">
                                    <span class="shard__lang">{{ $snippet->language }}</span>
                                    <button onclick="event.stopPropagation();copyCode(this,'{{ base64_encode($snippet->code) }}')" class="shard__copy">
                                        <span class="shard__tip">COPY</span><i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="shard__desc">{{ $snippet->description }}</p>
                            <div class="shard__meta">
                                <span class="shard__morse">{{ $morse }}</span>
                                <div class="shard__graph">@foreach($bars as $h)<div class="shard__bar" style="height:{{ $h }}px"></div>@endforeach</div>
                            </div>
                        </div>

                        <!-- Code block  -->
                        <div class="shard__code">
                            <div class="shard__code-bar">
                                <div class="shard__dots"><i class="dot dot--r"></i><i class="dot dot--y"></i><i class="dot dot--g"></i></div>
                                <span class="shard__file">main.{{ $ext }}</span>
                            </div>
                            <div class="shard__code-body">
                                <pre><code class="language-{{ $snippet->language }}">{{ $snippet->code }}</code></pre>
                            </div>
                        </div>

                        {{-- Particle canvas for assembly effect --}}
                        <canvas class="shard__particles" width="0" height="0"></canvas>
                    </article>
                    @endforeach
                    @endforeach
            </div>
        </section>
        @endforeach

        <div id="noResults" class="void hidden">
            <div class="void__icon"><i class="fa-solid fa-satellite-dish"></i></div>
            <p class="void__text">NO SIGNAL DETECTED</p>
            <p class="void__sub">Adjust search vector and retry</p>
        </div>
    </main>

    <footer class="foot">
        <div class="foot__inner">
            <span>CODE GALAXY &copy; {{ date('Y') }}</span>
            <div class="foot__tech"><span>LARAVEL</span><span>◇</span><span>PHP</span><span>◇</span><span>BLADE</span></div>
        </div>
    </footer>

    <script src="{{ asset('js/galaxy.js') }}"></script>
</body>

</html>