<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Add</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/vue@next"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
<noscript>
  <strong>We're sorry but this site doesn't work properly without JavaScript enabled. Please enable it to
    continue.</strong>
</noscript>
<div id="app">

  <div class="md:flex md:items-center md:justify-between p-6">
    <div class="min-w-0 flex-1">
      <h2 class="font-bold leading-7 text-gray-900 text-3xl">Product Add</h2>
    </div>
    <div class="flex space-x-4 mt-4 md:mt-0">

      <button type="button" @click="cancelAddingAProduct"
              class="inline-flex items-center rounded-md bg-slate-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
        Cancel
      </button>

      <button type="button" @click="addNewProduct"
              class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Save
      </button>
    </div>

  </div>

  <hr class="w-11/12 h-0.5 mx-auto bg-gray-100 border-0 rounded">

  <div class="p-6">
    <form id="product_form">
      <div class="flex flex-col w-auto max-w-md mx-auto space-y-4">

        <v-input type="text" id="sku" label="SKU" placeholder="sku" v-model="sku" :error-message="skuError"></v-input>
        <v-input type="text" id="name" label="NAME" placeholder="Name" v-model="name" :error-message="nameError"></v-input>
        <v-input type="text" id="price" label="PRICE ($)" placeholder="Price in $" v-model="price" :error-message="priceError"></v-input>


        <div>
          <label for="productType" class="block mb-2 text-sm font-medium text-gray-900">Select a Type</label>
          <select id="productType" v-model="productType"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            <option value="">Choose a type</option>
            <option v-for="type in productTypes" :value="type.id">{{type.name}}</option>
          </select>
          <small class="flex flex-col text-red-600 ml-3" v-if="productTypeError.length > 0" v-html="productTypeError"></small>
        </div>

        <div v-if="productTypeRequire === 'size'" class="flex flex-col space-y-4">

          <p class="font-bold text-indigo-500">
            Please provide the {{selectedProductType.require}} of the {{selectedProductType.name}}.
          </p>

          <v-input type="text" id="size" label="SIZE (MB)" placeholder="size in MB" v-model="size" :error-message="sizeError"></v-input>

        </div>

        <div v-if="productTypeRequire === 'weight'" class="flex flex-col space-y-4">

          <p class="font-bold text-indigo-500">
            Please provide the {{selectedProductType.require}} of the {{selectedProductType.name}}.
          </p>

          <v-input type="text" id="weight" label="WEIGHT (Kg)" placeholder="weight in Kg" v-model="weight" :error-message="weightError"></v-input>

        </div>

        <div v-if="productTypeRequire === 'dimensions'" class="flex flex-col space-y-4">

          <p class="font-bold text-indigo-500">
            Please provide the {{selectedProductType.require}} of the {{selectedProductType.name}}.
          </p>

          <v-input type="text" id="height" label="HEIGHT" placeholder="height" v-model="height" :error-message="heightError"></v-input>
          <v-input type="text" id="width" label="WIDTH" placeholder="width" v-model="width" :error-message="widthError"></v-input>
          <v-input type="text" id="length" label="LENGTH" placeholder="length" v-model="length" :error-message="lengthError"></v-input>

        </div>

      </div>


    </form>
  </div>

</div>

</body>


<script>

  const app = Vue.createApp({
    data() {
      return {
        productTypes: [],
        selectedProductType: null,

        sku: '',
        skuError: '',
        name: '',
        nameError: '',
        price: '',
        priceError: '',
        productType: '',
        productTypeError: '',
        size: null,
        sizeError: '',
        weight: null,
        weightError: '',
        height: null,
        heightError: '',
        width: null,
        widthError: '',
        length: null,
        lengthError: '',
      };
    },
    beforeCreate() {
      axios.get('/api/product-types')
          .then((res) => {
            this.productTypes = res.data
          })
    },
    computed: {
      productTypeRequire() {
        if(this.selectedProductType) {
          return this.selectedProductType.require
        }
        return '';
      }
    },
    watch: {
      productType(value) {
        this.selectedProductType = this.productTypes.find(obj => obj.id === value)
      }
    },
    methods: {
      resetValidationErrors() {
        Object.entries(this.$data).forEach(([k,v]) => {
          if(k.includes('Error')) {
            eval("this." + k + " = " + "'';")
          }
        })
      },
      setValidationErrors(errors) {
        Object.entries(errors).forEach(([k,v]) => {
          eval("this." + k + "Error" + " = " + "'" + v.join("<br>") + "';")
        })
      },
      addNewProduct() {

        this.resetValidationErrors();

        axios.post('/api/products', {
          sku: this.sku,
          name: this.name,
          price: this.price,
          productType: this.productType,
          productTypeRequire: this.productTypeRequire,
          size: this.size,
          weight: this.weight,
          height: this.height,
          width: this.width,
          length: this.length,
        }, { headers: {
            'Content-type': 'multipart/form-data'
          }})
            .then((res) => {
              window.location.href = '/products'
              // console.log(res)
            })
            .catch((error) => {
              if(error.response.status === 422) {
                this.setValidationErrors(error.response.data.errors)
              }
            })
      },
      cancelAddingAProduct() {
        window.location.href = '/products'
      },
    }
  });

  app.component('v-input', {
    template: `
      <div>
      <label :for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
      <input :type="type" :id="id" v-model="inputValue" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" :placeholder="placeholder" :required="required">
      <small class="flex flex-col text-red-600 ml-3" v-if="errorMessage.length > 0" v-html="errorMessage"></small>
      </div>
    `,
    props: {
      id: String, label: String, type: String, placeholder: String, modelValue: {},
      required: {
        required: false,
        default: true
      },
      errorMessage: {
        default: ''
      }
    },
    emits: ['update:modelValue'],
    data() {
      return {
        inputValue: this.modelValue,
      };
    },
    watch: {
      inputValue(current) {
        this.$emit('update:modelValue', current)
      }
    }
  });

  app.mount('#app');
</script>
</html>
