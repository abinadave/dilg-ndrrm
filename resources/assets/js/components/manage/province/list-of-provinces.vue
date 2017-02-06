<template>
    <div class="province-list">
        <!-- List of all provinces {{ provinces.length }} -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Province name</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="province in provinces">
                    <td>{{ province.name.toUpperCase() }}</td>
                    <td>0%</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<style type="text/css">
    .province-list {
        padding: 20px;
    }
</style>
<script>
    export default {
        mounted() {
            console.log('Component mounted. successfully');
        },
        props: {
            provinces: {
                type: Array
            }
        },
        methods: {
           
        }
    }
</script>
