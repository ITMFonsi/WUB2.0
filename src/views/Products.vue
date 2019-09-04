<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >

        <v-dialog v-model="dialog" max-width="500px">
<v-card>
  <v-card-title class="text-center justify-center py-6">
              <span class="headline">Edit Product</span>
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
    Tax
     <v-icon>mdi-cash</v-icon>
  </v-tab>
    <v-tab>
    Stock
     <v-icon>mdi-clipboard-outline</v-icon>
  </v-tab>
  <v-tab-item>
    <v-card flat>
      <v-card-text>
        
<v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs6
                  md4
                >
                  <v-text-field
                    label="Product Number"
                    v-model="editedItem.product_nr"
                  />
                </v-flex>
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
                  xs12
                  md12
                >
                  <v-text-field
                    label="Description"
                    v-model="editedItem.description"
                    />
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Price (NET)"
                    v-model="editedItem.price"/>
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Price (GROSS)"
                    v-model="editedItem.priceGross"/>
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
                  xs6
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Tax %"
                    v-model="editedItem.taxPercentage"
                  />
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
                  xs6
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Amount in stock"
                    v-model="editedItem.inStock"
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
</modal>

<modal height="auto" name="createProduct">
<v-card>
    <v-card-title class="text-center justify-center py-6">
              <span class="headline">New Product</span>
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
    Tax
     <v-icon>mdi-cash</v-icon>
  </v-tab>
    <v-tab>
    Stock
     <v-icon>mdi-clipboard-outline</v-icon>
  </v-tab>
  <v-tab-item>
    <v-card flat>
      <v-card-text>
        
<v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs6
                  md4
                >
                  <v-text-field
                    label="Product Number"
                    v-model="newProduct.product_nr"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Name"
                    v-model="newProduct.name"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Description"
                    v-model="newProduct.description"
                    />
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Price (NET)"
                    v-model="newProduct.price"/>
                </v-flex>
                <v-flex
                  xs6
                  md6
                >
                  <v-text-field
                    label="Price (GROSS)"
                    v-model="newProduct.priceGross"/>
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
                  xs6
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Tax %"
                    v-model="newProduct.taxPercentage"
                  />
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
                  xs6
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Amount in stock"
                    v-model="newProduct.inStock"
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
  color="green darken-1"
  v-on:click="addProduct"
>
<v-icon left>mdi-playlist-plus</v-icon>
  Add Product
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
                    <div class="headline mb-2">New Product</div>
                    Click here to add a new product.
                    </v-card-text>
                    <v-card-actions>
                    <v-btn class="ma-2" tile outlined color="green darken-3" @click="createProductModal">
                      <v-icon left>mdi-playlist-plus</v-icon> Add product
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
          title="Products"
          text="List of all products"

        >
        <v-flex
              xs4
        md4
      >
              <v-text-field
              append-icon="mdi-magnify"
        v-model="search"
        label="Search product..."
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
              <td>{{ item.product_nr }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.price }} €</td>
              <td>
                
                  <v-icon
                    small
                    color="orange"
                    class="mr-2"
                    @click="editItem(item)"
                    >
                        mdi-pencil
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
import DBProducts from '../database/Products'
import Product from '../models/Product'

export default {
methods: {
createProductModal () {
  this.$modal.show('createProduct');
},
hide () {
  this.$modal.hide('createProduct');
},

readProducts: function() {
  this.items = DBProducts.getAllProducts();
},

addProduct: function () {
  var newProduct = new Product();
  newProduct.setProduct_nr(this.newProduct.product_nr)
  newProduct.setName(this.newProduct.name)
  newProduct.setDescription(this.newProduct.description)
  newProduct.setPrice(this.newProduct.price)
  newProduct.setPriceGross(this.newProduct.priceGross)
  newProduct.setTaxPercentage(this.newProduct.taxPercentage)
  newProduct.setInStock(this.newProduct.inStock)

  var success = DBProducts.addProduct(newProduct);
  if (success) {
    this.success("Product successfully added!");
  } else {
    this.failed("Product could not be added!")
  }
},

updateProduct: function () {
  var toEdit = new Product();
    
  toEdit.setId(this.editedItem.id);
  toEdit.setProduct_nr(this.editedItem.product_nr);
  toEdit.setName(this.editedItem.name);
  toEdit.setDescription(this.editedItem.description);
  toEdit.setPrice(this.editedItem.price);
  toEdit.setPriceGross(this.editedItem.priceGross);
  toEdit.setTaxPercentage(this.editedItem.taxPercentage);
  toEdit.setInStock(this.editedItem.inStock);

  var success = DBProducts.updateProduct(toEdit);
  if (success) {
    this.success("Product edited successfully!");
    this.dialog = false;
  } else {
    this.failed("Product could not be edited!");
    this.dialog = false;
  }
},

deleteProduct: function (toDelete) {
  var success = DBProducts.deleteProduct(toDelete);
  if (success) {
    this.success("Product successfully deleted!");
  } else {
    this.failed("Product could not be deleted!");
  }
},
      
failed: function(text) {
  this.color = "error";
  this.notificationText = text;
  this.bottom = true
  this.snackbar = true;
  this.hide();
  this.readProducts();
},

success: function(text) {
  this.color = "success";
  this.notificationText = text;
  this.bottom = true
  this.snackbar = true;
  this.hide();
  this.readProducts();
},

editItem: function(item) {
  this.editedItem = Object.assign({}, item)
  this.dialog = true
},

deleteItem: function(item) {
  confirm('Are you sure you want to delete this product?') && this.deleteProduct(item);
},

save: function() {
  this.updateProduct();
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
      search:'',
         headers: [
        {
          sortable: true,
          text: 'Product Nr.',
          value: 'product_nr'
        },
        {
          sortable: false,
          text: 'Name',
          value: 'name'
        },
        {
          sortable: true,
          text: 'Price (NET)',
          value: 'price'
        },
        { 
        text: 'Actions', 
        value: 'action', 
        sortable: false 
        }
      ],
      items: [],
      newProduct: {
          product_nr: "",
          name: "",
          description: "",
          price: "",
          priceGross: '',
          taxPercentage: '',
          inStock: 0
      },
    editedItem: {
          id: "",
          product_nr: "",
          name: "",
          description: "",
          price: "",
          priceGross: '',         
          taxPercentage: '',
          inStock: 0
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
    this.readProducts();
  }
}
</script>
