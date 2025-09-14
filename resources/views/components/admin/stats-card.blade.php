@props([
    'count' => 0,
    'label' => 'Label',
    'trend' => null, // e.g. +10%
    'color' => 'indigo', // tailwind base color name
    'icon' => null,
    'text' => 'white', // white | black
])
@php
    $palette = [
        'indigo' => 'from-indigo-500 to-purple-500',
        'orange' => 'from-amber-500 to-rose-500',
        'green'  => 'from-emerald-500 to-teal-500',
        'blue'   => 'from-sky-500 to-indigo-500',
    ];
    $grad = $palette[$color] ?? $palette['indigo'];
    $isPositive = $trend && str_starts_with($trend, '+');
@endphp
@php 
    $textClass = $text === 'black' ? 'text-gray-900' : 'text-white';
    $labelClass = $text === 'black' ? 'text-gray-700' : 'opacity-80';
    $numberClass = $text === 'black' ? 'text-gray-900' : 'text-white';
@endphp
<div class="relative group rounded-xl p-5 bg-gradient-to-br {{ $grad }} {{ $textClass }} shadow-lg overflow-hidden transition-transform duration-300 hover:scale-[1.05] focus-within:scale-[1.05]">
    <div class="absolute inset-0 opacity-0 group-hover:opacity-20 transition-opacity bg-[radial-gradient(circle_at_30%_20%,white,transparent_60%)]"></div>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-wide font-semibold {{ $labelClass }}">{{ $label }}</p>
            <div class="flex items-end gap-2 mt-1">
                <span class="text-3xl font-bold leading-none {{ $numberClass }}" x-data="{val:0,target:{{ (int)$count }},started:false, step(){ if(this.val < this.target){ this.val += Math.ceil(this.target/40); if(this.val>this.target) this.val=this.target; requestAnimationFrame(()=>this.step()); } } }" x-intersect.once="if(!started){started=true;step();}" x-text="val"></span>
                @if($trend)
                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-white/15 backdrop-blur border border-white/20 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $isPositive ? 'rotate-0 text-emerald-300' : 'rotate-180 text-rose-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                        {{ $trend }}
                    </span>
                @endif
            </div>
        </div>
        @if($icon)
            <div class="p-2 rounded-lg bg-white/20 backdrop-blur shadow-inner">
                {!! $icon !!}
            </div>
        @endif
    </div>
    <div class="mt-4">
    <a href="#" class="text-xs font-medium inline-flex items-center gap-1 bg-white/15 hover:bg-white/25 transition-colors px-3 py-1.5 rounded-full">
            View All
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</div>