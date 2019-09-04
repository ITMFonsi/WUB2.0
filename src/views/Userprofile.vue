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
        xs6
        md4
      >
        <material-card class="v-card-profile">
          <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="150"
          >
            <img :src="profile.profilePic"
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

      <v-flex
      xs8
      md6
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
<material-card
          color="green"
          title="Banking Information"
          text="Used for invoicing"
        >
          <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    label="Account Owner"
                    v-model="profile.bankInfo.accOwner"
                    />
                </v-flex>
                <v-flex
                  xs12
                  md6
                >
                  <v-text-field
                    label="Bank Name"
                    v-model="profile.bankInfo.bank"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md6
                >
                  <v-text-field
                    label="IBAN"
                    v-model="profile.bankInfo.iban"
                    class="purple-input"/>
                </v-flex>
                <v-flex
                  xs12
                  md6
                >
                  <v-text-field
                    label="BIC"
                    v-model="profile.bankInfo.bic"
                    class="purple-input"/>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>
        </material-card>
        <v-btn color="green darken-1" @click="updateProfile" text>Update Profile</v-btn>
      </v-flex>

      <v-snackbar
              :color="color"
              :bottom="bottom"
              v-model="snackbar"
              dark
            >
              <v-icon
                color="white"
                class="mr-3"
              >
                mdi-bell-plus
              </v-icon>
              <div>{{ this.notificationText }}</div>
              <v-icon
                size="16"
                @click="snackbar = false"
              >
                mdi-close-circle
              </v-icon>
            </v-snackbar>


      
    </v-layout>
  </v-container>
</template>

<script>
  // axios test
  import firebase from 'firebase'
export default {
methods: {

  readProfile: function() {
    var me = this;
    var db = firebase.firestore();

    db.collection("userprofile").get().then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            me.profile = {
            id:doc.id,
            company:doc.data().company,
            name: doc.data().name,
            address:doc.data().address,
            city:doc.data().city,
            zip:doc.data().zip,
            country:doc.data().country,
            mail:doc.data().mail,
            phone:doc.data().phone,
            bankInfo: {
              accOwner:doc.data().bankInfo.accOwner,
              bank: doc.data().bankInfo.bank,
              iban:doc.data().bankInfo.iban,
              bic:doc.data().bankInfo.bic,
            },
            profilePic: doc.data().profilePic
            }
        });
    });
  },

  updateProfile: function() {
    var me = this;
    var db = firebase.firestore();
    var profileRef = db.collection("userprofile").doc(this.profile.id);

    profileRef.set({
        company:me.profile.company,
        name: me.profile.name,
        address:me.profile.address,
        city:me.profile.city,
        zip:me.profile.zip,
        country:me.profile.country,
        mail:me.profile.mail,
        phone:me.profile.phone,
        bankInfo: {
          accOwner:me.profile.bankInfo.accOwner,
          bank: me.profile.bankInfo.bank,
          iban:me.profile.bankInfo.iban,
          bic:me.profile.bankInfo.bic,
        },
        profilePic: me.profile.profilePic
    })
    .then(function(docRef) {
      me.success("Profile changes saved!");
    })
    .catch(function(error) {
      me.failed("Could not save profile!");
    });
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
            id: '',
            company:'',
            name: '',
            address:'',
            city:'',
            zip:'',
            country:'',
            mail:'',
            phone:'',
            bankInfo: {

            },
            profilePic: "",
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