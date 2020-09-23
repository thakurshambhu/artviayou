<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="{{url('/admin/profile')}}" class="simple-text logo-mini">
            <div class="logo-image-small">
               <img src="{{asset('assets/images/artvi-croppd.png')}}"/>
            </div>
        </a>
        <a href="{{url('admin/profile')}}" class="simple-text logo-normal">
            {{ __('Artviayou') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
           <!--  <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li> -->
            <li class="{{ $elementActive == 'buyers' || $elementActive == 'gallery' || $elementActive == 'artists' || $elementActive == 'artworks' || $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="{{ $elementActive == 'buyers' || $elementActive == 'gallery' || $elementActive == 'artists' || $elementActive == 'user' || $elementActive == 'profile' ? 'true' : 'false' }}" href="#laravelExamples" class="{{ $elementActive == 'buyers' || $elementActive == 'gallery' || $elementActive == 'artists' || $elementActive == 'user' || $elementActive == 'profile' ? 'collapsed' : '' }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>
                            {{ __('User Management') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'buyers'|| $elementActive == 'artworks'  || $elementActive == 'gallery' || $elementActive == 'artists' || $elementActive == 'user' || $elementActive == 'profile' ? 'show' : '' }}" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __('P') }}</span>
                                <span class="sidebar-normal">{{ __(' Profile ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'buyers' ? 'active' : '' }}">
                            <a href="{{ url('/admin/buyer') }}">
                                <span class="sidebar-mini-icon">{{ __('BM') }}</span>
                                <span class="sidebar-normal">{{ __(' Buyer Management ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'artists'|| $elementActive == 'artworks'  ? 'active' : '' }}">
                            <a href="{{ url('/admin/artist') }}">
                                <span class="sidebar-mini-icon">{{ __('AM') }}</span>
                                <span class="sidebar-normal">{{ __(' Artist Management ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'gallery' ? 'active' : '' }}">
                            <a href="{{ url('/admin/gallery') }}">
                                <span class="sidebar-mini-icon">{{ __('GU') }}</span>
                                <span class="sidebar-normal">{{ __(' Gallery User Management ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'categories' ? 'active' : '' }}">
                <a href="{{ url('/admin/category') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __('Category Management') }}</p>
                </a>
            </li>
              <li class="{{ $elementActive == 'subcategories' ? 'active' : '' }}">
                <a href="{{ url('/admin/subcategory') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __('SubCategory Management') }}</p>
                </a>
            </li>
             <li class="{{ $elementActive == 'subjects' ? 'active' : '' }}">
                <a href="{{ url('/admin/subject') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __('Subject Management') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'styles' ? 'active' : '' }}">
                <a href="{{ url('/admin/style') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __('Style Management') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'manage_artworks' || $elementActive == 'top_artwork' || $elementActive == 'trending_artwork' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="{{ $elementActive == 'manage_artworks' || $elementActive == 'top_artwork' || $elementActive == 'trending_artwork' ? 'true' : 'false' }}" href="#artwork_collapse" class="{{ $elementActive == 'manage_artworks' || $elementActive == 'top_artwork' || $elementActive == 'trending_artwork' ? 'collapsed' : '' }}">
                    <i class="nc-icon nc-image"></i>
                    <p>
                            {{ __('Artwork Management') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'manage_artworks' || $elementActive == 'top_artwork' || $elementActive == 'trending_artwork' ? 'show' : '' }}" id="artwork_collapse">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'manage_artworks' ? 'active' : '' }}">
                            <a href="{{ url('/admin/manage_artworks') }}">
                                <span class="sidebar-mini-icon">{{ __('A') }}</span>
                                <span class="sidebar-normal">{{ __(' Artwork ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'top_artwork' ? 'active' : '' }}">
                            <a href="{{ url('/admin/top_artwork') }}">
                                <span class="sidebar-mini-icon">{{ __('TA') }}</span>
                                <span class="sidebar-normal">{{ __(' Top Artwork ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'trending_artwork' ? 'active' : '' }}">
                            <a href="{{ url('/admin/trending_artwork') }}">
                                <span class="sidebar-mini-icon">{{ __('FA') }}</span>
                                <span class="sidebar-normal">{{ __(' Featured Artwork ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'manage_cms/about_us' || $elementActive == 'manage_cms/terms_n_conditions' || $elementActive == 'manage_cms/privacy_policy' || $elementActive == 'manage_cms/blog'|| $elementActive == 'manage_cms/home_page' || $elementActive == 'faq'? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="{{ $elementActive == 'manage_cms' ? 'true' : 'false' }}" href="#cms_collapse" class="{{ $elementActive == 'manage_cms' ? 'collapsed' : '' }}">
                    <i class="nc-icon nc-image"></i>
                    <p>
                            {{ __('CMS Management') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'manage_cms/about_us' || $elementActive == 'manage_cms/terms_n_conditions' || $elementActive == 'manage_cms/privacy_policy' || $elementActive == 'manage_cms/blog'|| $elementActive == 'manage_cms/home_page' || $elementActive == 'faq'? 'show' : '' }}" id="cms_collapse">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'manage_cms/about_us' ? 'active' : '' }}">
                            <a href="{{ url('/admin/manage_cms/about_us') }}">
                                <span class="sidebar-mini-icon">{{ __('AU') }}</span>
                                <span class="sidebar-normal">{{ __(' About Us ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'manage_cms/terms_n_conditions' ? 'active' : '' }}">
                            <a href="{{ url('/admin/manage_cms/terms_n_conditions') }}">
                                <span class="sidebar-mini-icon">{{ __('T&C') }}</span>
                                <span class="sidebar-normal">{{ __(' Terms & Conditions ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'manage_cms/privacy_policy' ? 'active' : '' }}">
                            <a href="{{ url('/admin/manage_cms/privacy_policy') }}">
                                <span class="sidebar-mini-icon">{{ __('PP') }}</span>
                                <span class="sidebar-normal">{{ __(' Privacy Policy ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'manage_cms/blog' ? 'active' : '' }}">
                            <a href="{{ url('/admin/manage_cms/blog') }}">
                                <span class="sidebar-mini-icon">{{ __('B') }}</span>
                                <span class="sidebar-normal">{{ __(' Blog ') }}</span>
                            </a>
                        </li>
                         <li class="{{ $elementActive == 'manage_cms/home_page' ? 'active' : '' }}">
                            <a href="{{ url('/admin/manage_cms/home_page') }}">
                                <span class="sidebar-mini-icon">{{ __('H') }}</span>
                                <span class="sidebar-normal">{{ __(' Home') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'faq' ? 'active' : '' }}">
                            <a href="{{ url('/admin/faq') }}">
                                <span class="sidebar-mini-icon">{{ __('F') }}</span>
                                <span class="sidebar-normal">{{ __(' FAQ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'payment_history' ? 'active' : '' }}">
                <a href="{{ url('/admin/payment_history') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __('payment history') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'site_setting' ? 'active' : '' }}">
                <a href="{{ url('/admin/site_setting') }}">
                    <i class="nc-icon nc-settings-gear-65"></i>
                    <p>{{ __('Site Setting') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>