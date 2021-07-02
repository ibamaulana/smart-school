<template>
  <div class="main-layout">
    <navbar />
    
    <div class="main-content ">
       <div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="row">
                  <div class="col-12">
                    <h3>Are you sure to logout ?</h3>
                  </div>
                  <div class="col-12 text-right mt-3">
                    <b-button variant='danger' @click="logout()" data-dismiss="modal">Logout</b-button>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
      <topbar />
      <div class="container-fluid mt-4">
        <child />
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import Topbar from '~/components/Topbar.vue'

export default {
  name: 'MainLayout',

  components: {
    Navbar,
    Topbar
  },

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
