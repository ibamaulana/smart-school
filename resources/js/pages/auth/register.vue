<template>
  <div class="row justify-content-center vh-100">
    <div class="col-lg-4 m-auto">
      <card v-if="mustVerifyEmail" class="p-4">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
        <div class="row" >
          <div class="col-md-12 text-center">
              <router-link to="/login" class="btn btn-white"> 
                <i class="fe fe-arrow-left mr-3"></i>Back to Login
              </router-link>
            </div>
        </div>
      </card>
      <card v-else class="p-4">
        <div class="row">
          <div class="col-12 text-center">
            <h1 class="title d-none d-lg-block">
              <b class="text-primary">SMART</b>SCHOOL
            </h1>
            <p>Register your school here</p>
            <hr>
          </div>
        </div>
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          
          <div class="form-group ">
            <label class="text-md-right">School ID</label>
            <div class="">
              <input v-model="form.school_code" :class="{ 'is-invalid': form.errors.has('school_code') }" class="form-control" type="text" name="school_code">
              <has-error :form="form" field="school_code" />
            </div>
          </div>

          <div class="form-group ">
            <label class="text-md-right">School Name</label>
            <div class="">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name" />
            </div>
          </div>

          <div class="form-group ">
            <label class=" text-md-right">Email</label>
            <div class="">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <div class="form-group ">
            <label class=" text-md-right">Password</label>
            <div class="">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <div class="form-group ">
            <label class=" text-md-right">Confirm Password</label>
            <div class="">
              <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="form" field="password_confirmation" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12 d-flex">
              <v-button :loading="form.busy" large block>
                <b>Register</b>
              </v-button>
            </div>
          </div>
        </form>
         <div class="row">
          <div class="col-12">
            <div class="text-center mb-2" >
              <p>Already have account ? <router-link to="/login"><b>Login here</b></router-link></p>
            </div>
          </div>
        </div>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },
  layout: 'basic',
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }),
    mustVerifyEmail: false
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')
      console.log(data)

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')
        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'home' })
      }
    }
  }
}
</script>
