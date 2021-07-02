<template>
<div>
  <b-modal id="data-modal" ref="data-modal" hide-footer title="Create">
    <div class="row">
      <div class="col-12">
        <form @submit.prevent="submitData" @keydown="form.onKeydown($event)">
          
          <div class="form-group " v-for="val in formfield" v-bind:key="val.id">
            <label class="text-md-right" v-if="val.type != 'hidden'">{{ val.label }}</label>
            <div class="" v-if="val.type != 'select'">
              <input v-model="form[val.key]" :class="{ 'is-invalid': form.errors.has(val.key) }" class="form-control" :type="val.type" :name="val.key">
              <has-error :form="form" :field="val.key" />
            </div>
            <div class="" v-else-if="val.type === 'select'">
              <select v-model="form[val.key]" :class="{ 'is-invalid': form.errors.has(val.key) }" class="form-control" :name="val.key">
                <option v-for="opt in val.dataselect" v-bind:key="opt.id" :value="opt.value">
                  {{opt.key}}
                </option>
              </select>
              <has-error :form="form" :field="val.key" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12 d-flex">
              <v-button :loading="form.busy" block>
                Submit
              </v-button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </b-modal>
  <b-modal id="delete-modal" ref="delete-modal" hide-footer hide-title>
    <div class="row">
      <div class="col-12">
        <h3>Are you sure to delete this data ?</h3>
      </div>
      <div class="col-12 text-right mt-3">
        <b-button variant='danger' @click="deletes()">Delete</b-button>
      </div>
    </div>
  </b-modal>
  <div class="row mb-3" v-if="is_create">
    <div class="col text-right">
      <b-button v-b-modal.data-modal @click="createData()">Create Data</b-button>
    </div>
  </div>
  <div class="table-responsive">
    <b-table
      id="my-table"
      :items="items"
      :fields="fields"
      :per-page="perPage"
      :current-page="currentPage"
      small
      striped
    >
      <template #cell(actions)="row" v-if="is_action">
        <b-button v-b-modal.data-modal size="sm" @click="detailData(row.item)" class="mr-1">
          Edit
        </b-button>
        <b-button v-b-modal.delete-modal size="sm" variant="danger" @click="deleteData(row.item.id)">
           Delete
        </b-button>
      </template>
      <template #cell(email_verified_at)="row" >
        <b v-if="row.item.email_verified_at == null" class="text-danger">Pending</b>
        <b v-else class="text-success">Active</b>

      </template>
    </b-table>
  </div>
  <b-pagination class="float-right"
    v-model="currentPage"
    :total-rows="rows"
    :per-page="perPage"
    aria-controls="my-table"
  ></b-pagination>
</div>
</template>

<script>
import axios from 'axios'
import Button from './Button.vue';
import Form from 'vform'

export default {
  components: { Button },
  props: {
    fields:[],
    url:null,
    createurl:null,
    updateurl:null,
    deleteurl:null,
    detailurl:null,
    param:{},
    formfield:[],
    is_create:true,
    is_action:true
  },
  watch: {
    param: function(){
      this.getData()
    }
  },
  data () {
    return {
      form: new Form({}),
      items: [],
      currentPage:1,
      rows:0,
      perPage:10,
      type:'create',
      deleteid: null
    }
  },
  beforeMount() {
    let formfields = {}
    this.formfield.map(e => {
      formfields[e.key] = ''
    })
    this.form = new Form(formfields)
  },
  mounted () {
    if(this.url){
      this.getData();
    }
  },
  methods: {
    getData () {
      axios.get(this.url,{
        params: this.param
      })
      .then(res => {
        this.currentPage = res.data.current_page
        this.perPage = res.data.per_page
        this.items = res.data.data
      }).catch(err => {
        console.log(err)
      })
    },
    createData () {
      this.type = 'submit'
      let formfields = {}
      this.formfield.map(e => {
        formfields[e.key] = ''
      })
      this.form = new Form(formfields)
    },
    detailData (item) {
      this.type = 'update'
      let formfields = {}
      this.formfield.map(e => {
        formfields[e.key] = item[e.key]
      })
      this.form = new Form(formfields)
    },
    deleteData (id) {
      this.deleteid = id
    },
    deletes(){
      axios.get(this.deleteurl,{
        params: {
          id: this.deleteid
        }
      })
      .then(res => {
         this.$bvToast.toast(res.message, {
          title: res.status,
          autoHideDelay: 3000,
        })
        this.getData()
        this.$refs['delete-modal'].hide()
      }).catch(err => {
        console.log(err)
      })
    },
    async submitData() {
      const { data } = await this.form.post(this.type === 'submit' ? this.createurl : this.updateurl)

      if(data){
        this.$bvToast.toast(data.message, {
          title: data.status,
          autoHideDelay: 3000,
        })
        this.getData()
        this.$refs['data-modal'].hide()
      }
    }
  }
}
</script>
