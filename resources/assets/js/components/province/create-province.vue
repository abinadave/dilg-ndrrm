<template>
	<div class="col-md-3 panel-officer">
	  <form @submit.prevent="saveProvince">
	       <div class="panel panel-default">
		        <div class="panel-heading">Create Province</div>
		        <div class="panel-body">
		              <label>
		              		Province name: <input v-model="name" type="text" class="form-control" />
		              </label>
		              <button type="submit" class="btn btn-success btn-sm">Save</button>
		        </div>
	      </div>
      </form>
    </div>
</template>
<style type="text/css">
  .panel-officer {
     margin-top: 10px;
  }
</style>
<script>
	
    export default {
        mounted() {

        },
        data(){
            return {
                name: ''
            }
        },
        methods: {
        	saveProvince(){
        		let self = this;
        		self.$http.post('/provice').then((resp) => {

        		}, () => {

        		})
        	}
        }
    }
</script>
