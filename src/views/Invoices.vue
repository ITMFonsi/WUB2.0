<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >

<template>
  <v-layout column align-center>
    <h3>Invoice Details</h3>
      <v-autocomplete
        :items="customers"
        item-text="name"
        v-model="selectedCustomers"
        label="Customer"
        return-object
        >
        </v-autocomplete>

      <v-text-field
        v-model="newInvoice.invoiceNumber"
        :rules="invoiceNumberRules"
        label="Invoice #"
        required
      ></v-text-field>

        <v-text-field
        v-model="newInvoice.invoiceDate"
        label="Invoice Date"
        required
      ></v-text-field>

      <v-text-field
        v-model="newInvoice.invoiceDueDate"
        label="Due Date"
      ></v-text-field>

      <v-checkbox
        color="green"
        v-model="newInvoice.invoiceOpen"
        label="Invoice paid"
        required
      ></v-checkbox>

      <v-flex
        xs6
      >
      <v-btn color="green" @click="postInvoice">Save</v-btn>
      </v-flex>

  </v-layout>
</template>

<v-flex>

<modal height="auto" name="createLineItem">
        <material-card
          color="green"
          title="New Line Item"
          text="Add a new line item to the invoice"
        >
          <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md12
                >
                  <v-autocomplete
                    :items="products"
                    v-model="selectedProduct"
                    label="Products"
                    item-text="name"
                    return-object
                    >
                    </v-autocomplete>   
                </v-flex>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Unit Price (NET)"
                    v-model="selectedProduct.price"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    label="Quantity"
                    class="purple-input"
                    v-model="selectedProduct.quantity"
                    />
                </v-flex>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Discount in %"
                    v-model="selectedProduct.discount"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md12
                >

               {{ ((this.selectedProduct.price * this.selectedProduct.quantity) * (1- (this.selectedProduct.discount / 100))).toFixed(2) }} €
                </v-flex>
                <v-flex
                  xs12
                  text-xs-right
                >
                  <v-btn
                    class="mx-0 font-weight-light"
                    color="success"
                    v-on:click="addLineItem"
                  >
                    Add Line Item
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>
        </material-card>
    </modal>

<v-flex>

<v-item-group>
   <h3 class="text-xs-center">Invoice: {{ newInvoice.invoiceNumber }}</h3>
    <v-container grid-list-md>
      <v-layout wrap>
          <v-item>
            <v-flex xs4>
                <material-card class="v-card-profile">
                  <v-avatar
                    slot="offset"
                    class="mx-auto d-block"
                    size="auto"
                  >
                    
                  </v-avatar>
                  <v-card-text class="text-xs-center">
                    <h6 class="category text-gray font-weight-thin mb-3">Invoice Recipient</h6>
                    <h4 class="card-title font-weight-light"> {{ selectedCustomers.name }} </h4>
                    <p class="card-description font-weight-light">{{ selectedCustomers.address }}</p>
                    <p class="card-description font-weight-light">{{ selectedCustomers.zip }} {{ selectedCustomers.city }}</p>
                    <p class="card-description font-weight-light">{{ selectedCustomers.country }}</p>
                  </v-card-text>
                </material-card>
              </v-flex>
          </v-item>

          <v-item>
            <v-flex xs4 offset-xs4>
              <material-card class="v-card-profile offset-xs8">
                <v-avatar
                  slot="offset"
                  class="mx-auto d-block"
                  size="auto"
                >
                  
                </v-avatar>
                <v-card-text class="text-xs-center">
                  <h6 class="category text-gray font-weight-thin mb-3">Invoice Issuer</h6>
                  <h4 class="card-title font-weight-light"> {{ profile.name }} </h4>
                  <p class="card-description font-weight-light">{{ profile.address }}</p>
                  <p class="card-description font-weight-light">{{ profile.zip }} {{ profile.city }}</p>
                  <p class="card-description font-weight-light">{{ profile.country }}</p>
                </v-card-text>
              </material-card>   
            </v-flex>
          </v-item>
      </v-layout>
    </v-container>
  </v-item-group>
  
</v-flex>
 <v-flex
        md12
      >
       <material-card
          color="green"
          title="Invoice"
          text="Line Items"
        >
          <v-data-table
            :headers="headers"
            :items="invoiceItems"
            no-data-text="Please add a line item"
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
              <td>{{ item.price }} €</td>
              <td>{{ item.quantity }}</td>
              <td>{{ item.discount }} %</td>
              <td>{{ item.total }} €</td>
              <td>
                    <v-icon
                        small
                        @click="deleteLineItem(index)"
                    >
                        mdi-delete
                    </v-icon>
                </td>
            </template>
          </v-data-table>
           <v-btn color="green" @click="createLineItemModal" text>Add Line Item</v-btn>

</material-card>
 </v-flex>
<v-flex xs4 offset-xs8>
  <material-card class="v-card-profile">
          <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="auto"
          >
            
          </v-avatar>
          <v-card-text class="text-xs-center">
            <h6 class="category text-gray font-weight-thin mb-3">Invoice Totals</h6>
            <p class="card-description font-weight-light">Total without tax: {{ newInvoice.invoiceTotalBeforeTax }} €</p>
            <p class="card-description font-weight-light">Tax: {{ newInvoice.invoiceTaxSum }} €</p>
            <p class="card-description font-weight-bold">Total: {{ newInvoice.invoiceTotal }} €</p>
          </v-card-text>
        </material-card>
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

</v-flex>


    </v-layout>
  </v-container>
</template>



<script>
  // axios test
import firebase from 'firebase'
import Router from 'vue-router'
import DBInvoices from '../database/Invoices'
import DBCustomers from '../database/Customers'
import DBProducts from '../database/Products'
import DBProfile from '../database/Profile'
import Invoice from '../models/Invoice'

export default {
  
methods: {
  createLineItemModal () {
    this.$modal.show('createLineItem');
  },

  hide () {
    this.$modal.hide('createLineItem');
  },

  readCustomers: function() {
    this.customers = DBCustomers.getAllCustomers();
  },

  failed: function(text) {
    this.color = "error";
    this.notificationText = text;
    this.bottom = true
    this.snackbar = true;
    this.hide();
  },

  success: function(text) {
    this.color = "success";
    this.notificationText = text;
    this.bottom = true
    this.snackbar = true;
    this.hide();
  },

  readProducts: function() {
    this.products = DBProducts.getAllProducts();
  },

  getNewInvoiceNumber: async function() {
    this.newInvoice.invoiceNumber = await DBInvoices.getNextInvoiceNumber();
  },

  readProfile: async function() {
    this.profile = await DBProfile.getInvoicerDetails();
  },

  postInvoice: function() {
    var success = DBInvoices.addInvoice(this.selectedCustomers, this.newInvoice, this.invoiceItems);
    if (success) {
      this.success("Invoice successfully created!");
      this.$router.push('/invoices');
    } else {
      this.failed("Invoice could not be created!");
      this.$router.push('/invoices');
    }
  },

  addLineItem() {      
    this.invoiceItems.push({ 
      name: this.selectedProduct.name,  
      price: this.selectedProduct.price,
      quantity: this.selectedProduct.quantity,
      discount: this.selectedProduct.discount,
      total: ((this.selectedProduct.price * this.selectedProduct.quantity) * (1- (this.selectedProduct.discount / 100))).toFixed(2)
    })
    this.success("Line item added successfully!");

    // calculate new invoice totals
    this.calculateTotals(this.selectedProduct.taxPercentage);
    // reset the line item
    this.resetAddLineItem()
  },

  resetAddLineItem() {
  this.selectedProduct = [];
  },

  deleteLineItem(index) {
    this.invoiceItems.splice(index, 1);
    this.calculateTotals();
    this.failed("Line item deleted!");
  },

  calculateTotals(tax) {
    var invoice = this.invoiceItems;
    var total = 0;
    // tax percentage
    if (tax == 'undefined') {
      tax = 1;
    }

    invoice.forEach(function(obj) {
      total += parseFloat(obj.total);
    });
    // total calculations
    this.newInvoice.invoiceTotalBeforeTax = total.toFixed(2);

    var taxSum = ((total /100) * tax).toFixed(2);
    this.newInvoice.invoiceTaxSum = taxSum;

    var totalSum =  (parseFloat(total) + parseFloat(taxSum)).toFixed(2);
    this.newInvoice.invoiceTotal = totalSum
  }
},

  data () {
    return {
      
         invoiceNumberRules: [
        v => !!v || 'Invoice # is required!',
        v => /^[0-9]*$/.test(v) || 'Invoice # must be a number',
      ],
        headers: [
        {
          sortable: false,
          text: 'Product Name',
          value: 'name'
        },
        {
          sortable: false,
          text: 'Unit Price (NET)',
          value: 'price'
        },
                {
          sortable: false,
          text: 'Quantity',
          value: 'quantity'
        },
                        {
          sortable: false,
          text: 'Discount',
          value: 'discount'
        },
                {
          sortable: false,
          text: 'Total',
          value: 'total'
        },
        { 
        text: 'Actions', 
        value: 'action', 
        sortable: false 
        }
      ],
        profile:[],
        products: [],
        customers: [],

        selectedCustomers:{},
        selectedProduct: {name:'', price:'', quantity:'1', discount:'0', total:''},

        newInvoice: {
            invoiceCustomer: '',
            invoiceNumber: '',
            invoiceDate: new Date().toJSON().slice(0,10),
            invoiceDueDate:new Date(Date.now() + 12096e5).toJSON().slice(0,10),
            invoiceOpen:'',
            invoiceTotalBeforeTax:'0',
            invoiceTaxSum:'0',
            invoiceTotal:'0'
        },
        invoiceItems: [],

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
        dialog: false
    }
  },
   mounted () {
    this.selectedCustomers.address = 'Select a customer!'; 
    this.readProfile();
    this.getNewInvoiceNumber();
    this.readCustomers();
    this.readProducts();
  }
}
</script>
