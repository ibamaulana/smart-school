<template>
  <div class="row justify-content-center vh-100">
    <div class="col-lg-4 m-auto">
      <card class="p-4">
        <div class="row">
          <div class="col-12 text-center">
            <h1 class="title d-none d-lg-block">
              <b class="text-primary">SMART</b>SCHOOL
            </h1>
            <p>Sign in with your account here</p>
            <hr>
          </div>
        </div>
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">

          <div class="form-group ">
            <label class="text-md-right">School Code</label>
            <div class="">
              <input v-model="form.school_code" :class="{ 'is-invalid': form.errors.has('school_code') }" class="form-control" type="text" name="school_code">
              <has-error :form="form" field="school_code" />
            </div>
          </div>

          <div class="form-group ">
            <label class="text-md-right">Username</label>
            <div class="">
              <input v-model="form.username" :class="{ 'is-invalid': form.errors.has('username') }" class="form-control" type="text" name="username">
              <has-error :form="form" field="username" />
            </div>
          </div>

          <div class="form-group">
            <label class="text-md-right">{{ $t('password') }}</label>
            <div class="">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12 d-flex">
              <checkbox v-model="remember" name="remember">
                {{ $t('remember_me') }}
              </checkbox>

              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                {{ $t('forgot_password') }}
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12 d-flex">
              <v-button :loading="form.busy" block>
                {{ $t('login') }}
              </v-button>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-12">
            <div class="text-center mb-2" >
              <p>New here ? <router-link to="/register"><b>Create an account</b></router-link></p>
            </div>
          </div>
        </div>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },
  layout: 'basic',
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.redirect()
    },

    redirect () {
      const intendedUrl = Cookies.get('intended_url')

      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({ path: intendedUrl })
      } else {
        this.$router.push({ name: 'home' })
      }
    }
  }
}
</script>