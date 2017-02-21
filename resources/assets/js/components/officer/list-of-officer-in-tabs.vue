<template>
    <div style="padding: 20px">Officers: {{ officers.length }}
        <table class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th>Municipal/City</th>
                    <th>Officer</th>
                    <th>Mobile No.</th>
                    <th>Landline No.</th>
                    <th>Email Address</th>
                    <th>Radio Frequency</th>
                    <th>Call Sign</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="officer in officers">
                    <td>{{ officer.city }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted. successfully');
        },
        props: {
            officers: {
                type: Array
            }
        }
    }
</script>
