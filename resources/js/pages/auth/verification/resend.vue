<template>
  <div class="row vh-100 align-items-center justify-content-center">
    <div class="col-lg-4 m-auto">
      <card :title="$t('verify_email')">
        <alert-success :form="form" :message="status" />

        <form @submit.prevent="send" @keydown="form.onKeydown($event)" v-if="!status">

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy">
                {{ $t('send_verification_link') }}
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
    return { title: this.$t('verify_email') }
  },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  created () {
    if (this.$route.query.email) {
      this.form.email = this.$route.query.email
    }
  },

  methods: {
    async send () {
      const { data } = await this.form.post('/api/email/resend')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
