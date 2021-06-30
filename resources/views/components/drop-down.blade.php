<!-- 
    =======================================================================
    Name    :   Pure CSS Dropdown Menu
    Author  :   Surjith S M
    Twitter :   @surjithctly

    Get more components here 👉 https://web3templates.com/components

    Copyright © 2021
    =======================================================================
 -->

<div class=" relative inline-block text-left dropdown">

    <span class="rounded-md shadow-sm"><button
            class="rounded-full inline-flex justify-center w-full text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
            type="button" aria-haspopup="true" aria-expanded="true" aria-controls="headlessui-menu-items-117">
            @if (auth()->user() && auth()->user()->avatar)
                <img src="{{ url('storage' . auth()->user()->avatar) }}"
                    class="rounded-full h-9 w-9 flex items-center justify-center" aria-haspopup="true"
                    aria-expanded="true" aria-controls="headlessui-menu-items-117" alt="">
            @else
                <img src="{{ url('storage/images/avatars/dog1.jpg') }}"
                    class="rounded-full h-9 w-9 flex items-center justify-center" aria-haspopup="true"
                    aria-expanded="true" aria-controls="headlessui-menu-items-117" alt="">
            @endif
        </button></span>
    <div
        class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
        <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
            aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
            @guest
                <div class="px-4 py-3">
                    <p class="text-sm font-medium leading-5 text-gray-900 truncate">{{ 'Login or register' }}</p>
                </div>
                @if (Route::has('login'))
                    <div class="py-1">
                        <a href="{{ route('login') }}" tabindex="0"
                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                            role="menuitem">Login</a>
                    </div>
                @endif
                @if (Route::has('register'))
                    <div class="py-1">
                        <a href="{{ route('register') }}" tabindex="0"
                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                            role="menuitem">Register</a>
                    </div>
                @endif

            @else
                <div class="px-4 py-3">
                    <p class="text-sm leading-5">Signed in as</p>
                    <p class="text-sm font-medium leading-5 text-gray-900 truncate"> Name  : {{ auth()->user()->name }}</p>
                    <p class="text-sm font-medium leading-5 text-gray-900 truncate"> Email : {{ auth()->user()->email }}</p>

                </div>
                <div class="py-1">
                    <a href="{{ route('home') }}" tabindex="0"
                        class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                        role="menuitem">Home</a>
                    <a href="{{ route('users.edit-profile') }}" tabindex="1"
                        class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                        role="menuitem">Profile</a>

                </div>
                <div class="py-1">
                    <a href="{{ route('logout') }}" tabindex="3"
                        class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                        role="menuitem"
                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    @endguest
</div>
@section('stypes')
    <style>
        .dropdown:focus-within .dropdown-menu {
            opacity: 1;
            transform: translate(0) scale(1);
            visibility: visible;
        }

    </style>
