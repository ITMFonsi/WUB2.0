<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >

    <v-dialog v-model="dialog" max-width="1000px"  max-height="1000px">
         <v-card>
        <v-card-text m12>
        <v-btn color="green darken-1" text @click="printDiv">Print</v-btn>
        </v-card-text>

<div class="invoice-box" id="invoice">
  <table cellpadding="0" cellspacing="0">
    <tr class="top">
      <td colspan="5">
        <table>
          <tr>
            <td class="title">
              <img src="http://s645270104.online.de/wub2/invoice/logo.jpg" style="width:100%; max-width:300px;">
            </td>

            <td>
              Rechnungsnummer: {{ item.invoiceNumber }}<br>Rechnungsdatum: {{ today }}<br>Fälligkeitsdatum: {{ item.invoiceDueDate }}
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="information">
      <td colspan="5">
        <table>
          <tr>
            <td>
              {{ item.invoiceCustomer.name }}<br> {{ item.invoiceCustomer.address }} <br> {{ item.invoiceCustomer.zip }} {{ item.invoiceCustomer.city }} <br> {{ item.invoiceCustomer.country }}
            </td>

            <td>
              {{ profile.name }}<br>{{ profile.address }}<br> {{ profile.zip }} {{ profile.city }}<br>{{ profile.country }}
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="heading">
      <td>Produkt</td>
      <td>Einzelpreis (Netto)</td>
      <td>Anzahl</td>
      <td>Rabatt</td>
      <td>Preis</td>
    </tr>

    <tr class="item" v-for="product in item.invoiceItems">
      <td>{{ product.name }}</td>
      <td>{{ product.price }} €</td>
      <td>{{ product.quantity }}</td>
      <td>{{ product.discount }} %</td>
      <td>{{ product.total }} €</td>
    </tr>

    <tr>
      <td colspan="4">
      </td>
    </tr>

    <tr class="">
      <td colspan="4"></td>
      <td>Zwischensumme: {{ item.invoiceTotalBeforeTax }} €</td>
    </tr>

    <tr class="">
      <td colspan="4"></td>
      <td>20% USt.: {{ item.invoiceTaxSum }} €</td>
    </tr>

    <tr class="total">
      <td colspan="4"></td>
      <td>Bruttosumme: {{ item.invoiceTotal }} €</td>
    </tr>


    <tr class="information">
      <td colspan="5">
        <table>
          <tr>
            <td>
            <h3>Zahlungsinformationen</h3>
              Kontoinhaber: {{ profile.name }} <br>
              Bank: {{ profile.bankInfo.bank }}<br>
              IBAN-Nummer: {{ profile.bankInfo.iban }}<br>
              BIC Code: {{ profile.bankInfo.bic }}<br>
              Verwendungszweck: Rechnungsnummer {{ item.invoiceNumber }}
            </td>
          </tr>
        </table>
      </td>
    </tr>

        <tr class="information">
      <td colspan="5">
        <table>
          <tr>
            <td>
            
            </td>
             <td>
                 Vielen Dank für Ihren Einkauf!<br>
                 {{ profile.name }}
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
        <v-card-text m12>
        </v-card-text>
        <v-flex xs12>
        <material-card
          color="green"
          title="Payment History"
          text="Added payments for this invoice"
        >
          <v-data-table
            :headers="paymentHistoryHeaders"
            :items="item.invoiceSumPaid"
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
              <td>{{ item.paymentDate }}</td>
              <td>{{ item.paymentMethod }}</td>
              <td>{{ item.amount }} €</td>
            </template>
          </v-data-table>
        </material-card>
        </v-flex>

 </v-card>


    </v-dialog>


        <v-dialog v-model="payment" max-width="500px">
          <v-card>
            <v-card-title>
              <span class="headline">Enter Payment</span>
            </v-card-title>

            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm12 md12>
                    <v-text-field v-model="paymentDate" label="Date"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-combobox
                      v-model="paymentMethod"
                      :items="paymentMethods"
                      label="Select a payment method"
                    ></v-combobox>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field v-model="amount" label="Amount"></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="closePayment">Cancel</v-btn>
              <v-btn color="green darken-1" text @click="enterPayment">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

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
                    <div class="headline mb-2">New Invoice</div>
                    Click here to add a new invoice.
                    </v-card-text>
                    <v-card-actions>
                    <v-btn class="ma-2" tile outlined color="green darken-3" @click="createInvoice">
                      <v-icon left>mdi-playlist-plus</v-icon> Add invoice
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
          title="Invoices"
          text="List of all invoices"

        >
        <v-flex
              xs4
        md4
      >
              <v-text-field
              append-icon="mdi-magnify"
        v-model="search"
        label="Search invoice..."
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
              <td>{{ item.invoiceDueDate }}</td>
              <td>{{ item.invoiceNumber }}</td>
              <td>{{ item.invoiceCustomer.name }}</td>
              <td>{{ item.invoiceTotal }} €</td>
              <td>
                   <v-icon
                   color="green"
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    >
                        mdi-information
                    </v-icon>
                    <v-icon
                        small
                        color="orange"
                        class="mr-2"
                        @click="openPayment(item)"
                    >
                        mdi-cash
                    </v-icon>
                    <v-icon
                        small
                        color="red"
                        class="mr-2"
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
import firebase from 'firebase'
import Router from 'vue-router'
import DBInvoices from '../database/Invoices'
import DBProfile from '../database/Profile'
import Invoice from '../models/Invoice'

export default {
methods: {
  printDiv: function() {
    var divText = document.getElementById("invoice").outerHTML;
    var myWindow = window.open('','','width=1400,height=1200');
    var doc = myWindow.document;
    doc.open();
    doc.write("<html><head>");
    doc.write("<link href='http://s645270104.online.de/api/print.css' rel='stylesheet' type='text/css'/>");
    doc.write("<body onload='window.print()'/></head>");
    doc.write(divText);
    doc.write("</html>");
    doc.close();
  },

  createProductModal () {
    this.$modal.show('createInvoice');
  },

  hide () {
    this.$modal.hide('createInvoice');
  },

  readInvoices: function() {
    this.items = DBInvoices.getAllInvoices();
  },

  readInvoicerDetails: async function() {
    this.profile = await DBProfile.getInvoicerDetails();
  },


  createInvoice: function () {
  this.$router.push('/newinvoice')  
  },

  updateInvoice: function () {

  },

  openPayment: function(item) {
  this.item = item;
  this.payment = true
  },

  closePayment: function(item) {
  this.payment = false
  },

  enterPayment: function () {
    var totalPaid = (parseFloat(this.item.invoiceSumPaid.totalPaid) + parseFloat(this.amount));

    var paymentTest = {
      "amount": this.amount,
      "paymentDate": this.paymentDate,
      "paymentMethod": this.paymentMethod
    }

    var success = DBInvoices.updatePaymentSum(this.item, paymentTest);
    if (success) {
      this.amount = 0;
      this.success("Payment added successfully!");
      this.payment = false;
    } else {
      this.failed("Could not add payment");
      this.payment = false;
    }
  },

  deleteInvoice: function (toDelete) {
    var success = DBInvoices.deleteInvoice(toDelete);
    if (success) {
      this.success("Invoice successfully deleted!");
    } else {
      this.failed("Invoice could not be deleted!");
    }
  },
   
  failed: function(text) {
    this.color = "error";
    this.notificationText = text;
    this.bottom = true
    this.snackbar = true;
    this.hide();
    this.readInvoices();
  },

  success: function(text) {
    this.color = "success";
    this.notificationText = text;
    this.bottom = true
    this.snackbar = true;
    this.hide();
    this.readInvoices();
  },

  editItem: function(item) {
    this.item = Object.assign({}, item);
    this.dialog = true
  },


  deleteItem: function(item) {
    confirm('Are you sure you want to delete this invoice?') && this.deleteInvoice(item);
  },

  save: function() {
    this.updateInvoice();
  },

  close: function() {
    this.dialog = false
    setTimeout(() => {
    this.editedItem = Object.assign({}, this.newProduct)
    this.editedIndex = -1
    }, 300)
  },
},

  data () {
    return {
      search:'',
         headers: [
        {
          sortable: true,
          text: 'Due Date',
          value: 'invoiceDueDate'
        },
        {
          sortable: false,
          text: 'Invoice #',
          value: 'invoiceNumber'
        },
        {
          sortable: true,
          text: 'Customer',
          value: 'invoiceCustomer.name'
        },
        {
          sortable: true,
          text: 'Total',
          value: 'invoiceTotal'
        },
        { 
        text: 'Actions', 
        value: 'action', 
        sortable: false 
        }
      ],
      headersDetail: [
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
        }
      ],
      paymentHistoryHeaders: [
        {
          sortable: true,
          text: 'Date',
          value: 'paymentDate'
        },
        {
          sortable: false,
          text: 'Method',
          value: 'paymentMethod'
        },
                {
          sortable: false,
          text: 'Amount',
          value: 'amount'
        }
      ],
      items: [],
      loading: true,
      color: null,
      colors: [
      'purple',
      'info',
      'success',
      'warning',
      'error'
    ],
    profile: {
      id: "",    
      company: "",
      name:  "",
      address: "",
      city: "",
      zip: "",
      country: "",
      mail: "",
      phone:"",
      bankInfo: {
        accOwner:"",
        bank: "",
        iban:"",
        bic:"",
      },
      profilePic: ""
    },
    item: {
     invoiceCustomer: {
            id: "",
            name:  "",
            mail:  "",
            phone1:  "",
            address:  "",
            city:  "",
            zip:  "",
            country:  "",
        },
        invoiceNumber: "",
        invoiceDate:  "",
        invoiceDueDate:  "",
        invoiceOpen: "",
        invoiceItems: [],
        invoiceTotalBeforeTax:  "",
        invoiceTaxSum: "",
        invoiceTotal: "",
        invoiceSumPaid: [],
    },
    today: new Date().toISOString().slice(0, 10),
    paymentMethods: ["Bank Transfer", "Cash", "Other"],
    amount: 0,
    paymentMethod: '',
    paymentDate: new Date().toJSON().slice(0,10),
    openBalance: '',
    bottom: false,
    notificationText: "",
    snackbar: false,
    dialog: false,
    payment: false,
    }
  },
  mounted () {
    this.readInvoicerDetails();
    this.readInvoices();
  }
}
</script>


<style>
.invoice-box {
  max-width: 800px;
  margin: auto;
  padding: 30px;
  border: 1px solid #eee;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
  font-size: 16px;
  line-height: 24px;
  font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
  color: #555;
}

.invoice-box table {
  width: 100%;
  line-height: inherit;
  text-align: left;
}

.invoice-box table td {
  padding: 5px;
  vertical-align: top;
}

.invoice-box table tr td:nth-child(n + 2) {
  text-align: right;
}

.invoice-box table tr.top table td {
  padding-bottom: 20px;
}

.invoice-box table tr.top table td.title {
  font-size: 45px;
  line-height: 45px;
  color: #333;
}

.invoice-box table tr.information table td {
  padding-bottom: 40px;
}

.invoice-box table tr.heading td {
  background: #eee;
  border-bottom: 1px solid #ddd;
  font-weight: bold;
}

.invoice-box table tr.details td {
  padding-bottom: 20px;
}

.invoice-box table tr.item td {
  border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
  border-bottom: none;
}

.invoice-box table tr.item input {
  padding-left: 5px;
}

.invoice-box table tr.item td:first-child input {
  margin-left: -5px;
  width: 100%;
}

.invoice-box table tr.total td:nth-child(2) {
  border-top: 2px solid #eee;
  font-weight: bold;
}

.invoice-box input[type="number"] {
  width: 60px;
}

@media only screen and (max-width: 600px) {
  .invoice-box table tr.top table td {
    width: 100%;
    display: block;
    text-align: center;
  }

  .invoice-box table tr.information table td {
    width: 100%;
    display: block;
    text-align: center;
  }
}

/** RTL **/
.rtl {
  direction: rtl;
  font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial,
    sans-serif;
}

.rtl table {
  text-align: right;
}

.rtl table tr td:nth-child(2) {
  text-align: left;
}

</style>