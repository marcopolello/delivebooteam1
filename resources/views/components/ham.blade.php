<div :style="{visibility: !showHam ? 'visible' : 'hidden'}" class="hamburger-home">

    <svg @click='openHam()' height="30" width="30" viewBox="0 0 24 24" class="burger">
        <path d="M2 13V11H22V13H2ZM2 19V17H22V19H2ZM2 7V5H22V7H2Z"></path>
    </svg>

</div>

<transition
    name="custom-classes-transition"
    enter-active-class="animated fadeInLeft"
    leave-active-class="animated fadeOutLeft"
>

<div v-if='showHam == true' id="open-hamburger-menu">


    <i @click='closeHam()' class="closebtn-ham far fa-window-close"></i>

    @auth
        <nav class="bm-item-list">
            <ul>
                <li>
                    <a href="http://localhost:8000" class="active">HOME</a>
                </li> 
                <div>
                    <li>
                        <a href="http://localhost:8000/restaurant" class="">Dashboard</a>
                    </li> 
                    <li>
                        <a href="http://localhost:8000/logout">Logout</a>
                    </li>
                </div>
            </ul>
        </nav>
    @endauth

    @guest
        <nav class="bm-item-list">
            <ul>
                <li>
                    <a href="http://localhost:8000" class="active">HOME</a>
                </li> 
                <div>
                    <li>
                        <a href="http://localhost:8000/register" class="">Register</a>
                    </li> 
                    <li>
                        <a href="http://localhost:8000/login" class="">Login</a>
                    </li>
                </div>
            </ul>
        </nav>
    @endguest

</div>

</transition>