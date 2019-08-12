<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >
      <v-flex
        xs12
        md8
      >
        <material-card
          color="green"
          title="Your Profile"
          text="Your user profile"
        >
          <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    label="Company"
                    v-model="profile.company"
                    disabled/>
                </v-flex>
                <v-flex
                  xs12
                  md6
                >
                  <v-text-field
                    label="Name"
                    v-model="profile.name"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md6
                >
                  <v-text-field
                    label="E-Mail Address"
                    v-model="profile.mail"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md6
                >
                  <v-text-field
                    label="Phone Number"
                    v-model="profile.phone"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Address"
                    v-model="profile.address"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="City"
                    v-model="profile.city"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="Country"
                    v-model="profile.country"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    class="purple-input"
                    v-model="profile.zip"
                    label="Postal Code"
                    type="number"/>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>
        </material-card>
      </v-flex>
      <v-flex
        xs12
        md4
      >
        <material-card class="v-card-profile">
          <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="130"
          >
            <img
              src="https://demos.creative-tim.com/vue-material-dashboard/img/marc.aba54d65.jpg"
            >
          </v-avatar>
          <v-card-text class="text-xs-center">
            <h6 class="category text-gray font-weight-thin mb-3">Managing Director</h6>
            <h4 class="card-title font-weight-light">{{profile.name}}</h4>
            <p class="card-description font-weight-light">{{profile.address }}</p>
            <p class="card-description font-weight-light">{{profile.zip }} {{profile.city }}</p>
            <p class="card-description font-weight-light">{{profile.country }}</p>
          </v-card-text>
        </material-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  // axios test
import axios from 'axios'
export default {
methods: {

  readProfile: function() {
    axios
        .get('http://s645270104.online.de/api/profile.php?action=read')
        .then(response => {
        this.profile = response.data;
        this.profile = this.profile[0];
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },
      toFormData: function (obj) {
  		var form_data = new FormData();
  		for (var key in obj) {
  			form_data.append(key, obj[key]);
          }
  		return form_data;
      },
    failed: function(text) {
          this.color = "error";
          this.notificationText = text;
          this.bottom = true
            this.snackbar = true;
            this.readProfile();
      },
      success: function(text) {
        this.color = "success";
        this.notificationText = text;
        this.bottom = true
        this.snackbar = true;
        this.readProfile();
      },
      save: function() {
          this.updateProfile();
      },
      close: function() {
          this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.newProduct)
          this.editedIndex = -1
        }, 300)
      }
},

  data () {
    return {
        item:[],
        profile: {
            company:'',
            name: '',
            address:'',
            city:'',
            zip:'',
            country:'',
            mail:'',
            phone:''
        },
      loading: true,
      color: null,
      colors: [
      'purple',
      'info',
      'success',
      'warning',
      'error'
    ],
    bottom: false,
    notificationText: "",
    snackbar: false,
    dialog: false,
    }
  },
  mounted () {
    this.readProfile();
  }
}
</script>