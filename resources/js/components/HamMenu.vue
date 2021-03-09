<template>
    <div class="menu">
      <div ref="sideNav" class="bm-menu">
        <nav class="bm-item-list">
            <ul>
                
                <span v-if="this.user">
                  <li><a :href="this.dashboard">Dashboard</a></li>
                  <li><a :href="this.logout">Logout</a></li>
                </span>

                <span v-else>

                  <li><a :href="this.register">Register</a></li>
                  <li><a :href="this.login">Login</a></li>

                </span>
              
            </ul>
        </nav>
        <span class="bm-cross-button cross-style" 
            @click="closeMenu" 
            >

            <!-- cross -->
            <svg height="24" width="24" viewBox="0 0 24 24" class="cross">
              <path d="M12.0001 10.2322L5.88398 4.11612L4.11621 5.88389L10.2323 12L4.11621 18.1161L5.88398 19.8839L12.0001 13.7678L18.1162 19.8839L19.884 18.1161L13.7679 12L19.884 5.88389L18.1162 4.11612L12.0001 10.2322Z"></path>
            </svg>
        </span>
      </div>

      <div class="bm-burger-button" 
        @click="openMenu" 
        >
        
        <!-- burger -->
        <svg height="24" width="24" viewBox="0 0 24 24" class="burger">
          <path d="M2 13V11H22V13H2ZM2 19V17H22V19H2ZM2 7V5H22V7H2Z"></path>
        </svg>

      </div>
    </div>
</template>
<script>
    export default {
      name: 'menubar',
      data() {
        return {
          
          // login: this.login,
          // register: this.register,
          // dashboard: this.dashboard,
          // logout: this.logout,
          // user: this.user,

          isSideBarOpen: false,
        };
      },
      props: {

        login: String,
        register: String,
        dashboard: String,
        logout: String,
        user: ""
      },

      methods: {
        openMenu() {
          this.$emit('openMenu');
          this.isSideBarOpen = true;
          if (!this.noOverlay) {
            document.body.classList.add('bm-overlay');
          }
          this.$nextTick(function() {
            this.$refs.sideNav.style.width = this.width
              ? this.width + 'px'
              : '300px';
          });
        },
        closeMenu() {
          this.$emit('closeMenu');
          console.log(this.$emit('closeMenu'));
          this.isSideBarOpen = false;
          document.body.classList.remove('bm-overlay');
          this.$refs.sideNav.style.width = '0px';
        }, 
      },
    };
</script>

<style>

    .bm-burger-button {
      cursor: pointer;
    }
    
    .cross-style {
      position: absolute;
      top: 12px;
      right: 2px;
      cursor: pointer;
    }
   
    .bm-menu {
      height: 100%; /* 100% Full-height */
      width: 0; /* 0 width - change this with JavaScript */
      position: fixed; /* Stay in place */
      z-index: 1000; /* Stay on top */
      top: 0;
      left: 0;
      background-color: white; 
      overflow-x: hidden; /* Disable horizontal scroll */
      padding-top: 60px;
      transition: 1s; /*second transition effect to slide in the sidenav*/
    }
    .bm-overlay {

      background: rgba(0, 0, 0, 0.3);
    }
    .bm-item-list {
      margin-left: 10%;
      font-size: 20px;
    }
    .bm-item-list > * {
      padding: 0.7em;
    }
    .bm-item-list > * > span {
      font-weight: 700;
    }
    .bm-item-list ul{
        list-style: none;
    }
    .bm-item-list li a{
        display: block;
        color: #00ccbc;
        text-decoration: none;
        padding: 20px 0;
    }

</style>