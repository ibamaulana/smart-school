<template>
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white">
    <div class="container-fluid">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        <b class="text-primary">SMART</b> SCHOOL
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link " to="/home" >
              <i class="fe fe-grid"></i> Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link " to="/users" >
              <i class="fe fe-users"></i> Users
            </router-link>
          </li>
        </ul>
        <hr class="navbar-divider my-3">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link " to="/settings" >
              <i class="fe fe-user"></i> Account
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logout-modal">
              <i class="fe fe-log-out"></i>Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.navbar-brand{
  margin-bottom:20px;
}
.nav-link{
  color:#4dbbf8!important;
}
.navbar-nav .nav-link>.fe{
  font-size: 2.0625rem;
  margin-right: 10px;
}
.nav-link.router-link-active::before {
  border-color: white !important;
}
.nav-link.router-link-active {
  background-color: #4dbbf8;
  color:white!important;
}
.navbar-vertical.navbar-expand-md .navbar-nav .nav-link {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
