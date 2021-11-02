<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">{{ config()->get('app.name') }}</a>
        </div>
        <ul class="sidebar-menu">
            @if (Auth::user()->role_id == 1)
                {{-- admin view --}}
                @can('dashboard.index')
                    <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                            <span>{{ __('Dashboard') }}</span></a>
                    </li>
                @endcan
                @can('plan.create', 'plan.index', 'plan.edit', 'plan.delete')
                    <li class="{{ Request::is('admin/plan*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-paper-plane"></i>
                            <span>{{ __('Plan') }}</span></a>
                        <ul class="dropdown-menu" style="display: none;">
                            <li><a class="nav-link" href="{{ route('admin.plan.create') }}">{{ __('Create Plan') }}</a>
                            </li>
                            <li><a class="nav-link" href="{{ route('admin.plan.index') }}">{{ __('All Plans') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('currency.create', 'currency.index', 'currency.edit', 'currency.delete')
                    <li class="{{ Request::is('admin/currency*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-rupee-sign"></i>
                            <span>{{ __('Currency') }}</span></a>
                        <ul class="dropdown-menu" style="display: none;">
                            <li><a class="nav-link"
                                    href="{{ route('admin.currency.create') }}">{{ __('Create Currency') }}</a></li>
                            <li><a class="nav-link"
                                    href="{{ route('admin.currency.index') }}">{{ __('Manage Currency') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('payment-gateway.index', 'payment-gateway.edit', 'payment-gateway.delete')
                    <li class="{{ Request::is('admin/payment-gateway*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                class="far fa-money-bill-alt"></i>
                            <span>{{ __('Payment Gateway') }}</span></a>
                        <ul class="dropdown-menu" style="display: none;">
                            <li><a class="nav-link"
                                    href="{{ route('admin.payment-gateway.index') }}">{{ __('Manage Payment Gateway') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('merchant.index', 'merchant.create', 'merchant.edit')
                    <li class="{{ Request::is('admin/merchant*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('Merchant') }}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link"
                                    href="{{ route('admin.merchant.create') }}">{{ __('Create Merchant') }}</a></li>
                            <li><a class="nav-link"
                                    href="{{ route('admin.merchant.index') }}">{{ __('All Merchant') }}</a></li>
                        </ul>
                    </li>
                @endcan

                @can('order.index', 'order.create', 'order.edit')
                    <li class="{{ Request::is('admin/order*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                class="fas fa-sort-amount-up"></i>
                            <span>{{ __('Orders') }}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link"
                                    href="{{ route('admin.order.create') }}">{{ __('Create Order') }}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.order.index') }}">{{ __('All Orders') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <li class="{{ Request::is('admin/user-plan') ? 'active' : '' }}">
                    <a href="{{ url('admin/user-plan') }}" class="nav-link"><i class="fas fa-spa"></i>
                        <span>{{ __('User Plan') }}</span></a>
                </li>
                @can('report')
                    <li
                        class="{{ Request::is('admin/report') ? 'active' : '' }}{{ Request::is('admin/user-plan-report') ? 'active' : '' }}{{ Request::is('admin/payment-report') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-arrows-alt"></i>
                            <span>{{ __('Report') }}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link"
                                    href="{{ route('admin.report.index') }}">{{ __('Order Report') }}</a></li>
                            <li><a class="nav-link"
                                    href="{{ route('admin.user-plan-report.index') }}">{{ __('User Plan Report') }}</a>
                            </li>
                            <li><a class="nav-link"
                                    href="{{ route('admin.payment-report.index') }}">{{ __('Payment Report') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('transaction')
                    <li class="{{ Request::is('admin/payment-report*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                            <span>{{ __('Payment') }}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link"
                                    href="{{ route('admin.payment-report.index') }}">{{ __('All Payment') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('blog.index', 'blog.create')
                    <li class="{{ Request::is('admin/blog*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fab fa-blogger"></i>
                            <span>{{ __('Blog') }}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link"
                                    href="{{ route('admin.blog.create') }}">{{ __('Blog Create') }}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.blog.index') }}">{{ __('Blog List') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('page.index', 'page.create')
                    <li class="{{ Request::is('admin/page*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-scroll"></i>
                            <span>{{ __('Page') }}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link"
                                    href="{{ route('admin.page.create') }}">{{ __('Page Create') }}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.page.index') }}">{{ __('Page List') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                <li class="{{ Request::is('admin/frontend/settings*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-cog"></i>
                        <span>{{ __('Frontend Settings') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('service.index', 'service.create')
                            <li><a class="nav-link"
                                    href="{{ route('admin.service.index') }}">{{ __('Service List') }}</a>
                            </li>
                        @endcan
                        @can('quick-start.index')
                            <li><a class="nav-link"
                                    href="{{ url('admin/frontend/settings/quick-start-section') }}">{{ __('Quick start') }}</a>
                            </li>
                        @endcan
                        @can('hero-section')
                            <li><a class="nav-link"
                                    href="{{ url('admin/frontend/settings/hero-section') }}">{{ __('Hero Section Edit') }}</a>
                            </li>
                        @endcan
                        @can('gateway-section')
                            <li><a class="nav-link"
                                    href="{{ url('admin/frontend/settings/gateway-section') }}">{{ __('Gateway Section') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @can('support')
                    <li class="nav-item dropdown {{ Request::is('admin/support*') ? 'show active' : '' }}">
                        <a href="{{ route('admin.support.index') }}" class="nav-link"><i class="fas fa-headset"></i>
                            <span>{{ __('Support') }}</span></a>
                    </li>
                @endcan

                <li
                    class="nav-item dropdown {{ Request::is('admin/menu') ? 'show active' : '' }} {{ Request::is('admin/language') ? 'show active' : '' }} {{ Request::is('admin/setting/env') ? 'show active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cogs"></i>
                        <span>{{ __('Settings') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('admin/setting/env') ? 'active' : '' }}">
                            <a href="{{ url('admin/setting/env') }}"
                                class="nav-link"><span>{{ __('System Environment') }}</span></a>
                        </li>
                        @can('language.index')
                            <li class="{{ Request::is('admin/language') ? 'active' : '' }}">
                                <a href="{{ route('admin.language.index') }}"
                                    class="nav-link"><span>{{ __('Languages') }}</span></a>
                            </li>
                        @endcan
                        @can('menu')
                            <li><a class="nav-link"
                                    href="{{ route('admin.menu.index') }}">{{ __('Menu Settings') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="{{ Request::is('admin/theme/settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.theme.settings') }}" class="nav-link"><i class="fab fa-ethereum"></i>
                        <span>{{ __('Theme Settings') }}</span></a>
                </li>
                <li class="nav-item dropdown {{ Request::is('admin/option*') ? 'show active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i>
                        <span>{{ __('Site Options') }}</span></a>
                    <ul class="dropdown-menu">
                        <li>
                        <a class="nav-link" href="{{ route('admin.option.edit', 'cron_option') }}">{{ __('Cron Option') }}</a>
                        </li>
                         <li>
                        <a class="nav-link" href="{{ route('admin.option.edit', 'env') }}">{{ __('System Environment') }}</a>
                        </li>
                        <li><a class="nav-link"
                                href="{{ route('admin.option.edit', 'all') }}">{{ __('Site Option') }}</a></li>
                        <li><a class="nav-link"
                                href="{{ route('admin.option.seo-index') }}">{{ __('SEO Settings') }}</a></li>
                    </ul>
                </li>

                @can('role.list')
                    <li
                        class="nav-item dropdown {{ Request::is('admin/role') ? 'show active' : '' }} {{ Request::is('admin/admin') ? 'show active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                class="fas fa-shield-alt"></i><span>{{ __('Admin and roles') }}</span></a>
                        <ul class="dropdown-menu">
                            @can('role.list')
                                <li><a class="nav-link" href="{{ route('admin.role.index') }}">{{ __('Roles') }}</a></li>
                            @endcan
                            @can('admin.list')
                                <li><a class="nav-link" href="{{ route('admin.admin.index') }}">{{ __('Admins') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            @elseif(Auth::user()->role_id == 2)
                {{-- user view --}}
                <li class="menu-header">{{ __('Dashboard') }}</li>
                <li class="nav-item {{ Request::is('merchant/dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('merchant.dashboard') }}"><i
                            class="fas fa-tachometer-alt"></i><span>{{ __('Dashboard') }}</span></a>
                </li>
                <li class="menu-header">{{ __('Manage Request') }}</li>
                <li class="{{ Request::is('merchant/request*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-share-square"></i>
                        <span>{{ __('Manage Request') }}</span></a>
                    <ul class="dropdown-menu">
                        @if(getplandata('menual_req') == 1)
                        <li><a class="nav-link" href="{{ route('merchant.request.create') }}">{{ __('Create Request') }}</a>
                        </li>
                        @endif
                        <li><a class="nav-link"
                                href="{{ route('merchant.request.index') }}">{{ __('Manage Request') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-header">{{ __('Form Generator') }}</li>
                <li class="nav-item dropdown {{ Request::is('merchant/form*') ? 'show active' : '' }}">
                    <a href="{{ route('merchant.form.generate') }}" class="nav-link"><i class="fas fa-plug"></i>
                        <span>{{ 'Form Generator' }}</span></a>
                </li>
                <li class="menu-header">{{ __('Manage Plan') }}</li>
                <li class="nav-item {{ Request::is('merchant/plan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('merchant.plan.index') }}"><i
                            class="fas fa-columns"></i><span>{{ __('Manage Plan') }}</span></a>
                </li>
                <li class="{{ Request::is('merchant/gateway*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('merchant.gateway.index') }}"><i
                            class="fas fa-money-check-alt"></i>
                        <span>{{ __('Payment Gateway') }}</span></a>
                </li>
                <li class="{{ Request::is('merchant/payment-report') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('merchant.payment-report.index') }}"><i
                            class="fas fa-chart-bar"></i>
                        <span>{{ __('Payment Report') }}</span></a>
                </li>
                <li class="menu-header">{{ __('Support Management') }}</li>
                <li class="{{ Request::is('merchant/support') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('merchant.support.index') }}"><i
                            class="fas fa-headset"></i><span>{{ __('Manage Support') }}</span></a>
                </li>
                <li class="menu-header">{{ __('Settings') }}</li>
                <li class="nav-item {{ Request::is('merchant/settings*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('merchant.settings.index') }}"><i class="fas fa-cog"></i>
                        <span>{{ __('Settings') }}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>
                        <span>{{ __('Logout') }}</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
