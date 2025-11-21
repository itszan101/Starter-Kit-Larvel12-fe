<!-- BEGIN: Side Menu -->
<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <a href="{{ route('dashboard') }}" class="d-flex text-decoration-none align-items-center">
                <i class="bi bi-command me-2" style="font-size: 1.1rem;"></i>
                <span class="logo-text fw-semibold" style="padding-top: 0.8rem;">Algo Admin</span>
            </a>
            <div class="sidebar-toggler x">
                <a href="#" class="sidebar-hide d-xl-none d-block">
                    <i class="bi bi-x bi-middle"></i>
                </a>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                {{-- Loop menu --}}
                @foreach ($navigation_links as $link)
                    @if (!$link->is_multi)
                        <!-- Single menu -->
                        <li class="sidebar-title">{{ $link->text }}</li>
                        <li class="sidebar-item {{ request()->routeIs($link->href) ? 'active' : '' }}">
                            <a href="{{ route($link->href) }}" class="sidebar-link">
                                <i class="{{ $link->section_icon }}"></i>
                                <span>{{ $link->text }}</span>
                            </a>
                        </li>
                    @else
                        <!-- Multi menu -->
                        <li class="sidebar-title">{{ $link->text }}</li>
                        @php
                            $firstSectionIcon =
                                collect($link->href ?? [])->first()?->section_icon ?? 'bi bi-three-dots';

                            $isActive = collect($link->href ?? [])
                                ->flatMap(fn($section) => $section->section_list ?? [])
                                ->pluck('href')
                                ->contains(fn($r) => request()->routeIs($r));
                        @endphp
                        <li class="sidebar-item has-sub {{ $isActive ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="{{ $firstSectionIcon }}"></i>
                                <span>{{ $link->text }}</span>
                            </a>

                            <ul class="submenu {{ $isActive ? 'active submenu-open' : '' }}">
                                @foreach ($link->href ?? [] as $section)
                                    @foreach ($section->section_list ?? [] as $item)
                                        <li class="submenu-item {{ request()->routeIs($item->href) ? 'active' : '' }}">
                                            <a href="{{ route($item->href) }}"
                                                class="submenu-link d-flex align-items-center gap-3">
                                                <i class="{{ $item->icon ?? 'bi bi-dot' }}"></i>
                                                <span>{{ $item->text }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- END: Side Menu -->
