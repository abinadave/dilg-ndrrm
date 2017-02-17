<template>

        <div class="container">
            <h3 class="page-header">
              <span>Province: </span>
              <span class="text-primary">
                {{ province.name.toUpperCase() }}
              </span>
            </h3>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
              <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">...</div>
              <div role="tabpanel" class="tab-pane" id="profile">...</div>
              <div role="tabpanel" class="tab-pane" id="messages">...</div>
              <div role="tabpanel" class="tab-pane" id="settings">...</div>
            </div>

        </div>
             
    </div>
</template>

<script>
    export default {
        data(){
           return {
              provinceId: 0,
              province: { name: 'Waiting....', id: 0 }
           }
        },
        mounted() {
           this.setProvinceId();
        },
        methods: {
            setProvinceId(){
               let self = this;
               let provinceId = router.currentRoute.fullPath.split('/').pop();
               self.provinceId = provinceId;
            },
            fetch(){
                let self = this;
                let resource = self.$resource('/Provinces/All/Tabs/{id}');
                resource.get({
                    id: self.provinceId
                }).then((resp) => {
                    if (resp.status === 200) {
                        let json = resp.body;
                        self.province = json.province;
                    }
                }, (resp) => {

                });
            }
        },
        watch: {
          '$route' (to, from) {
             // react to route changes...
             this.setProvinceId();
          },
          'provinceId': function(newVal, oldVal){
             this.fetch();
          }
        }
    }
</script>
