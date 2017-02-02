<template>
    <div>
    {{ pagination.total }}
       <nav aria-label="Page navigation">
          <ul class="pagination">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>

                <li v-for="n in totalButtons">
                    <a href="#">1</a>
                </li>
                
                <li>
                  <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
          </ul>
        </nav>
    </div>
</template>
<style type="text/css">
    .right {
        text-align: right;
    }
</style>
<script>
    export default {
        props: {
            pagination: {
                type: Object
            }
        },
        data(){
            return {
                
            }
        },
        mounted() {
          
        },
        components: {
           
        },
        computed: {
            totalButtons(){
                let self = this;
                // return 100 / 15;
            }
        },
       
    }
</script>
