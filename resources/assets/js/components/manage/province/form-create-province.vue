<template>
    <div style="padding: 20px">
        <form @submit.prevent="createProvince">
            <label>
                Province Name
                <input ref='search' type="text" v-model="name" class="form-control">
                <span v-text="error.name"></span>
            </label>
            <button style="display: none" type="submit"></button>
        </form>
        <hr>
    </div>
</template>
<script>
    import toastr from 'toastr'
    export default {
        mounted() {
            console.log('Component mounted. successfully')
        },
        data(){
            return {
                name: '',
                error: {
                    name: ''
                }
            }
        },
        methods: {
            createProvince(){
                let self = this;
                self.clearErrMsgs();
                axios.post('/province', {
                    name: self.name
                })
                .then(function (response) {
                    let province = response.data;
                    if (province.id > 0) {
                        self.name = '';
                        self.$refs.search.focus();
                        toastr.success('Province: ['+province.name+'] successfully created.');
                        self.$emit('provinceadded', province);
;                    }
                })
                .catch(function (error) {
                    if(error.response.status === 422){
                        let json = error.response.data;
                        $.each(json, function(index, val) {
                            self.error[index] = val;
                        });
                    }
                });
            },
            clearErrMsgs(){
                let self = this;
                self.error.name = '';
            }
        }
    }
</script>
