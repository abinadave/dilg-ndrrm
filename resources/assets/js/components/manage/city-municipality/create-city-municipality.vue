
<template>
    <div style="padding: 25px">
        <form @submit.prevent="createCity">
            <label>
                City/Municipality:
                <input ref="name" v-model="form.name" type="text" class="form-control">
            </label><br>
            <label>
            	Province:
            	<select v-model="form.province" class="form-control">
            		<option :value="province.id" v-for="province in provinces">
            			{{ province.name }}
            		</option>
            	</select>
            </label><br>
            <button type="submit" class="btn btn-default btn-primary">Submit</button>
            <hr>
        </form>
    </div>
</template>

<script>
	import toastr from 'toastr'
    export default {
        mounted() {
            console.log('Component create-city-municipality.vue successfully');
        },
        props: {
        	provinces: {
        		type: Array
        	}
        },
        data(){
        	return {
        		form: {
        			name: '',
        			province: ''
        		}
        	}
        },
        methods: {
        	createCity(){
        		let self = this;
        		console.log('name: ' + self.form.name);
        		console.log('province: ' + self.form.province);
        		axios.post('/city/municipality', self.form)
        		.then(function (response) {
        			if (response.status === 200) {
        				let json = response.data;
        				self.$emit('cityadded', json);
        				self.form.name = '';
                        self.$refs.name.focus();
                        toastr.success('City/Municipality successfully created.');
        			}
        		})
        		.catch(function (error) {
        			console.log(error);
        		});
        	}
        }
    }
</script>
