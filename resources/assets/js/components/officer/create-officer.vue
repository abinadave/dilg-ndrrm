<template>
    <div>
        <div class="col-md-7 panel-officer">
        
            <div class="panel panel-primary">
              <!-- Default panel contents -->
              <div class="panel-heading">Officer</div>
                <div class="panel-body">
                     <form>
                        <label>Province:
                            <select class="form-control">
                                <option selected disabled>Select province&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                <option v-for="province in provinces">{{ province.name }}</option>
                            </select>
                        </label>
                        <label>Officer name:
                            <input type="text" class="form-control">
                        </label>
                        <label>Municipality:
                            <select class="form-control">
                                <option selected disabled>Select Municipality</option>
                            </select>
                        </label>
                    </form>
                </div>
              <!-- Table -->
              <table class="table">
                ...
              </table>
            </div>
        </div>
        <create-province></create-province>
    </div>
</template>
<style type="text/css">
  .panel-officer {
     margin-top: 10px;
  }
</style>
<script>
    import CompCreateProvince from '../province/create-province.vue'
    
    export default {
        mounted() {

        },
        components: {
          'create-province': CompCreateProvince
        },
        data(){
            return {
                provinces: [
                    { name: 'Biliran' },
                    { name: 'Eastern Samar' },
                    { name: 'Leyte' },
                    { name: 'Northern Samar' },
                    { name: 'Western Samar' },
                    { name: 'Southern Leyte' },
                ]
            }
        }
    }
</script>
