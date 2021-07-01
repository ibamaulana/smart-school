<template>
  <div class="card" >
    <div class="card-header">
      <ul role="tablist" class="nav nav-tabs card-header-tabs" >
        <li role="presentation" class="nav-item" 
          v-bind:class="{
            'active' : role === 2
          }"
        >
            <a href="javascript:void(0)" class="nav-link"
              v-bind:class="{
                'active' : role === 2
              }"
              @click="changeRole(2)"
            >Teacher</a>
        </li>
        <li role="presentation" class="nav-item" 
          v-bind:class="{
            'active' : role === 3
          }"
        >
            <a href="javascript:void(0)" class="nav-link"
              v-bind:class="{
                'active' : role === 3
              }"
              @click="changeRole(3)"
            >Student</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="row justify-content-center align-items-center">
        <div class="col-12 col-lg-12">
         <table-data
          url='/api/user/data'
          :param="{
            role_id: role
          }"
          :fields="fields"
          :formfield="form"
          createurl='/api/user/submit'
          updateurl='/api/user/update'
          deleteurl='api/user/delete'
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import TableData from '../components/TableData.vue'

export default {
  components: { TableData },
  data () {
    return {
      role: 2,
      fields: [
        { key: 'name', label: 'Name', sortable: true, sortDirection: 'asc' },
        { key: 'username', label: 'Username', sortable: true, class: 'text-center' },
        { key: 'email', label: 'Email', sortable: true, class: 'text-center' },
        {
          key: 'email_verified_at',
          label: 'Is Active',
          formatter: (value, key, item) => {
            return value ? 'Active' : 'Pending'
          },
          sortable: true,
          sortByFormatted: true,
          filterByFormatted: true
        },
        { key: 'actions', label: 'Actions' }
      ],
      form:[
        {
          label: 'Name',
          key: 'name',
          type: 'text'
        },
        {
          label: 'Username',
          key: 'username',
          type: 'text'
        },
        {
          label: 'Email',
          key: 'email',
          type: 'email'
        },
        {
          label: 'ID',
          key: 'id',
          type: 'hidden'
        },
        {
          label: 'Role',
          key: 'role',
          type: 'select',
          dataselect: [
            {
              key: 'Teacher',
              value: 2
            },
            {
              key: 'Student',
              value: 3
            },
          ]
        },
      ]
    }
  },
  middleware: 'auth',
  computed: mapGetters({
    user: 'auth/user'
  }),
  metaInfo () {
    return { title: this.$t('home') }
  },
  methods:{
    changeRole(role){
      this.role = role
    }
  }
  
}
</script>
