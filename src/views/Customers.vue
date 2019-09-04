<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >

    <v-dialog v-model="detailDialog" max-width="800px">
          <v-card>
            <v-card-title class="text-center justify-center py-6">
              <span class="headline">Customer Details</span>
    </v-card-title>

<v-flex xs8 md4 sm4

>
<v-card 
    class="mx-auto"
    color="white"
    width="200px"
  >
    <v-card-text class="text-xs-center">
       <h4 class="card-title font-weight-light">{{editedItem.name}}</h4>
            <p class="card-description font-weight-light">{{editedItem.address }}</p>
            <p class="card-description font-weight-light">{{editedItem.zip }} {{editedItem.city }}</p>
            <p class="card-description font-weight-light">{{editedItem.country }}</p>
    </v-card-text>
  </v-card>
</v-flex>

       <material-card
          color="green"
          title="Invoices"
          text="Customers invoices"
        >
          <v-data-table
            :headers="headersInvoice"
            :items="customerInvoices"
            loading-text="Loading... Please wait"
          >
            <template
              slot="headerCell"
              slot-scope="{ header }"
            >
              <span
                class="font-weight-light text-success text--darken-3"
                v-text="header.text"
              />
            </template>
            <template
              slot="items"
              slot-scope="{ index, item }"
            >
              <td>{{ item.invoiceDueDate }}</td>
              <td>{{ item.invoiceNumber }}</td>
              <td>{{ item.invoiceCustomer.name }}</td>
              <td>{{ item.invoiceTotal - item.invoiceSumPaid }} €</td>
            </template>
          </v-data-table>

        </material-card>
          </v-card>
        </v-dialog>

        <v-dialog v-model="dialog" max-width="800px">
<v-card>
    <v-card-title class="text-center justify-center py-6">
              <span class="headline">Edit Customer</span>
    </v-card-title>
    <v-tabs
      background-color="deep-purple accent-4"
      centered
      icons-and-text
>
  <v-tab>
    Gerneral
    <v-icon>mdi-information</v-icon>
  </v-tab>
    <v-tab>
    Other
     <v-icon>mdi-dots-horizontal</v-icon>
  </v-tab>
  <v-tab-item>
    <v-card flat>
      <v-card-text>
        <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Name"
                    v-model="editedItem.name"
                  />
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Phone Number"
                    v-model="editedItem.phone1"
                  />
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Email Address"
                    v-model="editedItem.mail"
                    />
                </v-flex>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Adress"
                    v-model="editedItem.address"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="City"
                    v-model="editedItem.city"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="Country"
                    v-model="editedItem.country"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="Postal Code"
                    type="number"
                    v-model="editedItem.zip"/>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>

      </v-card-text>
    </v-card>
  </v-tab-item>
  <v-tab-item>
    <v-card flat>
      <v-card-text>
        <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Comments"
                    v-model="editedItem.comments"
                  />
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>
      </v-card-text>
    </v-card>
  </v-tab-item>  
</v-tabs>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="green darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
  </v-card>

        </v-dialog>

<modal height="auto" name="createCustomer">

<v-card>
    <v-card-title class="text-center justify-center py-6">
              <span class="headline">New Customer</span>
    </v-card-title>
    <v-tabs
      background-color="deep-purple accent-4"
      centered
      icons-and-text
>
  <v-tab>
    Gerneral
    <v-icon>mdi-information</v-icon>
  </v-tab>
    <v-tab>
    Other
     <v-icon>mdi-dots-horizontal</v-icon>
  </v-tab>
  <v-tab-item>
    <v-card flat>
      <v-card-text>
        <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Name"
                    v-model="newCustomer.name"
                  />
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Phone Number"
                    v-model="newCustomer.phone1"
                  />
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Email Address"
                    v-model="newCustomer.mail"
                    />
                </v-flex>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Adress"
                    v-model="newCustomer.address"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="City"
                    v-model="newCustomer.city"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="Country"
                    v-model="newCustomer.country"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="Postal Code"
                    type="number"
                    v-model="newCustomer.zip"/>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>

      </v-card-text>
    </v-card>
  </v-tab-item>
  <v-tab-item>
    <v-card flat>
      <v-card-text>
        <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Comments"
                    v-model="newCustomer.comments"
                  />
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>
      </v-card-text>
    </v-card>
  </v-tab-item>  
</v-tabs>
<v-flex
  xs12
  text-xs-right
>
               
<v-btn
  class="mx-0 font-weight-light"
  color="success"
  v-on:click="addCustomer"
>
<v-icon left>mdi-account-plus</v-icon> Add customer
</v-btn>
 </v-flex>
  </v-card>
    </modal>


      <v-flex
        md12
      >
        <v-layout>
            <v-flex xl4 xs4 order-md1 order-xs3>
                <v-card
                    color="green"
                    dark
                    >
                <v-card-text class="white--text">
                    <div class="headline mb-2">New Customer</div>
                    Click here to add a new customer.
                    </v-card-text>
                    <v-card-actions>
                    <v-btn class="ma-2" tile outlined color="green darken-3" @click="createCustomerModal">
                      <v-icon left>mdi-account-plus</v-icon> Add customer
                    </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-flex>

      <v-flex
        md12
      >

       <material-card
          color="green"
          title="Customers"
          text="List of all customers"
        >
              <v-flex
              xs4
        md4
      >
              <v-text-field
              append-icon="mdi-magnify"
        v-model="search"
        label="Search customer..."
      ></v-text-field>
            </v-flex>
          <v-data-table
            :headers="headers"
            :items="items"
            :search="search"
            loading-text="Loading... Please wait"
          >
            <template
              slot="headerCell"
              slot-scope="{ header }"
            >
              <span
                class="font-weight-light text-success text--darken-3"
                v-text="header.text"
              />
            </template>
            <template
              slot="items"
              slot-scope="{ index, item }"
            >
              <td>{{ item.name }}</td>
              <td>{{ item.mail }}</td>
              <td>{{ item.phone1 }}</td>
              <td>
                <v-icon
                    small
                    color="green"
                    class="mr-2"
                    @click="showItem(item)"
                    >
                        mdi-information
                    </v-icon>
                  <v-icon
                    small
                    color="orange"
                    class="mr-2"
                    @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        color="red"
                        small
                        @click="deleteItem(item)"
                    >
                        mdi-delete
                    </v-icon>
                </td>
            </template>
          </v-data-table>

        </material-card>
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
      </v-flex>
    </v-layout>
    
  </v-container>
</template>

<script>
import DBCustomers from '../database/Customers'
import Customer from '../models/Customer'

export default {
methods: {
  createCustomerModal () {
    this.$modal.show('createCustomer');
  },

  hide () {
    this.$modal.hide('createCustomer');
  },

  readCustomers: function() {
    this.items = DBCustomers.getAllCustomers();
  },

  addCustomer: function() {
    var newCustomer = new Customer();

    newCustomer.setName(this.newCustomer.name);
    newCustomer.setMail(this.newCustomer.mail);
    newCustomer.setPhone1(this.newCustomer.phone1);
    newCustomer.setAddress(this.newCustomer.address);
    newCustomer.setCity(this.newCustomer.city);
    newCustomer.setZip(this.newCustomer.zip);
    newCustomer.setCountry(this.newCustomer.country);
    newCustomer.setComments(this.newCustomer.comments);

    var success = DBCustomers.addCustomer(newCustomer);
    if (success) {
      this.success("Customer successfully added!");
    } else {
      this.failed("Customer could not be added!")
    }
    
  },

  updateCustomer: function () {
    var toEdit = new Customer();
    toEdit.setId(this.editedItem.id);
    toEdit.setName(this.editedItem.name);
    toEdit.setMail(this.editedItem.mail);
    toEdit.setPhone1(this.editedItem.phone1);
    toEdit.setAddress(this.editedItem.address);
    toEdit.setCity(this.editedItem.city);
    toEdit.setZip(this.editedItem.zip);
    toEdit.setCountry(this.editedItem.country);
    toEdit.setComments(this.editedItem.comments);

    var success = DBCustomers.updateCustomer(toEdit);
    if (success) {
      this.success("Customer edited successfully!");
      this.dialog = false;
    } else {
      this.failed("Customer could not be edited!");
      this.dialog = false;
    }
  },
      
  deleteCustomer: function (toDelete) {
    var success = DBCustomers.deleteCustomer(toDelete);
    if (success) {
      this.success("Customer successfully deleted!");
    } else {
      this.failed("Customer could not be deleted!");
    }
  },

  failed: function(text) {
    this.color = "error";
    this.notificationText = text;
    this.bottom = true
    this.snackbar = true;
    this.hide();
    this.readCustomers();
  },
  success: function(text) {
    this.color = "success";
    this.notificationText = text;
    this.bottom = true
    this.snackbar = true;
    this.hide();
    this.readCustomers();
  },
  showItem: function(item) {
    this.editedItem = Object.assign({}, item)
    // get customers items

    this.customerInvoices = DBCustomers.getInvoiceForCustomer(item);
    console.log(this.customerInvoices);
    // get sums of invoices
    var revenue = 0;
    this.customerInvoices.map(function(obj){     
      revenue += parseFloat(obj.invoiceTotal);    
    });
    this.CustomerRevenueSum = revenue.toFixed(2) + ' €';
    this.detailDialog = true
  },

  editItem: function(item) {
    this.editedItem = Object.assign({}, item)
    this.dialog = true
  },
  deleteItem: function(item) {
    confirm('Are you sure you want to delete this customer?') && this.deleteCustomer(item);
  },
  save: function() {
      this.updateCustomer();
  },
  close: function() {
      this.dialog = false
    setTimeout(() => {
      this.editedItem = Object.assign({}, this.newCustomer)
      this.editedIndex = -1
    }, 300)
  },
},

  data () {
    return {
      search: '',
         headers: [
        {
          sortable: false,
          text: 'Name',
          value: 'name'
        },
                {
          sortable: false,
          text: 'E-Mail',
          value: 'mail'
        },
                {
          sortable: false,
          text: 'Phone',
          value: 'phone1'
        },
        { 
        text: 'Actions', 
        value: 'action', 
        sortable: false 
        }
      ],
      headersInvoice: [
                      {
          sortable: true,
          text: 'Due Date',
          value: 'date'
        },
        {
          sortable: false,
          text: 'Invoice',
          value: 'invoice'
        },
                {
          sortable: false,
          text: 'Customer',
          value: 'customer',
        },
        {
          sortable: false,
          text: 'Balance Due',
          value: 'total',
        }
      ],
      items: [],
      newCustomer: {
          name: "",
          mail: "",
          phone1: "",
          address: "",
          city: "",
          zip: "",
          country: "",
          comments:''
      },
    editedItem: {
            id: "",
          name: "",
          mail: "",
          phone1: "",
          address: "",
          city: "",
          zip: "",
          country: "",
          comments:''
      },
      customerInvoices: [],
      CustomerRevenueSum: 0,
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
    detailDialog: false
    }
  },
  mounted () {
    this.readCustomers();
  }
}
</script>
