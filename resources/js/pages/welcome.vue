<template>
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100 ">
      <div class="col-12 col-lg-5 py-4 my-lg-0">
        <div class="row">
          <div class="col-12 text-left">
            <div class="text-left mb-2" >
              <img src="/img/logo-dark.png" style="width:60%">
            </div>
            <h1 class="title d-none d-lg-block">
              <b class="text-primary">SMART</b><br>SCHOOL
            </h1>
            <h1 class="title-small d-lg-none">
              <b class="text-primary">SMART</b><br>SCHOOL
            </h1>
            <div class="mt-2">
            <template v-if="authenticated">
              <router-link :to="{ name: 'home' }">
                {{ $t('home') }}
              </router-link>
            </template>
            <template v-else>
              <router-link class="btn btn-lg btn-primary" :to="{ name: 'login' }">
                {{ $t('login') }}
              </router-link>
              <router-link class="btn btn-lg btn-outline btn-primary" :to="{ name: 'register' }">
                {{ $t('register') }}
              </router-link>
            </template>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-7 text-center">
        <img src="/img/bg-2.png" style="width:80%">
      </div>
      
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 80px;
}
.title-small{
  font-size: 60px;
}
</style>
