<template>
    <div class="col-md-12">
        <div>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Officer List</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Create Officer</a></li>
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Trashed Officers</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <officer-list></officer-list>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
                <create-officer></create-officer>
            </div>
            <div role="tabpanel" class="tab-pane" id="messages">...</div>
            <div role="tabpanel" class="tab-pane" id="settings">...</div>
          </div>

        </div>
    </div>
</template>

<script>
    import CompCreateOfficer from './create-officer.vue'
    import CompOfficerList   from './officer-list.vue'
    export default {
        mounted() {
           
        },
        components: {
            'create-officer': CompCreateOfficer,
            'officer-list': CompOfficerList
        }
    }
</script>
