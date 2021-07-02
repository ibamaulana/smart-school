<template>
  <div class="row vh-100 align-items-center justify-content-center">
    <div class="col-lg-4 ">
      <card :title="$t('reset_password')">
        
        <alert-success :form="form" :message="status" />

        <form @submit.prevent="reset" @keydown="form.onKeydown($event)" v-if="!status">
          
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email" readonly>
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="form" field="password_confirmation" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy">
                {{ $t('reset_password') }}
              </v-button>
            </div>
          </div>
        </form>
        <div class="row" v-else>
          <div class="col-md-12 text-center">
              <router-link to="/login" class="btn btn-white"> 
                <i class="fe fe-arrow-left mr-3"></i>Back to Login
              </router-link>
            </div>
        </div>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',
  layout:'basic',
  metaInfo () {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/api/password/reset')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
