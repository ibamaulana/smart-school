<template>
  <div class="row vh-100 align-items-center justify-content-center">
    <div class="col-lg-4 m-auto">
      <card :title="$t('verify_email')">
        <template v-if="success">
          <div class="alert alert-success" role="alert">
            {{ success }}
          </div>
          <div class="row">
            <div class="col-md-12 text-center">
              <router-link :to="{ name: 'login' }" class="btn btn-white">
                <i class="fe fe-arrow-left mr-3"></i> Back to Login
              </router-link>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="alert alert-danger" role="alert">
            {{ error || $t('failed_to_verify_email') }}
          </div>
          <div class="row">
            <div class="col-md-12 text-right">
              <router-link :to="{ name: 'verification.resend' }" class="btn btn-white">
                {{ $t('resend_verification_link') }}
              </router-link>
            </div>
          </div>
        </template>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

const qs = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')

export default {
  async beforeRouteEnter (to, from, next) {
    try {
      const { data } = await axios.post(`/api/email/verify/${to.params.id}?${qs(to.query)}`)

      next(vm => { vm.success = data.status })
    } catch (e) {
      next(vm => { vm.error = e.response.data.status })
    }
  },
  layout:'basic',
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('verify_email') }
  },

  data: () => ({
    error: '',
    success: ''
  })
}
</script>
