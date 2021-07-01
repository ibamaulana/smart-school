<template>
  <card >
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-lg-8">
        <h1>Welcome to SmartSchool</h1>
        <p>School Name : {{user.school.name}}</p>
        <p>School Code : {{user.school.school_code}}</p>
      </div>
      <div class="col-12 col-lg-4 text-right">
        <img src="/img/bg-2.png" style="width:50%">
      </div>
    </div>
  </card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',
  computed: mapGetters({
    user: 'auth/user'
  }),
  metaInfo () {
    return { title: this.$t('home') }
  }
  
}
</script>
