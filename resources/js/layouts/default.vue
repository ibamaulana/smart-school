<template>
  <div class="main-layout">
    <navbar />

    <div class="main-content ">
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
  }
}
</script>
