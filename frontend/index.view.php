<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product list</title>
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
      <h2 class="font-bold leading-7 text-gray-900 text-3xl">Product List</h2>
    </div>
    <div class="flex space-x-4 mt-4 md:mt-0">
      <button type="button" @click="deleteMany"
              class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
        MASS DELETE
      </button>

      <button type="button" @click="goToAddPage"
              class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset hover:bg-indigo-500 focus-visible:outline-indigo-600">
        ADD
      </button>
    </div>

  </div>

  <hr class="w-11/12 h-0.5 mx-auto bg-gray-100 border-0 rounded">

  <div class=" p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mx-auto max-w-7xl">

    <div v-for="product in products" key="product.id" @click="addToDeleteCheckbox(product.id)" class="w-full h-48 bg-slate-50 drop-shadow-md rounded border-2 p-4">

      <input v-model="deleteCheckbox" type="checkbox" :value="product.id" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-0 float-left delete-checkbox">

      <div class="h-full flex flex-col items-center justify-around">
        <p>{{product.sku}}</p>
        <p>{{product.name}}</p>
        <p>{{product.price}}</p>
        <p v-if="product.productType.require === 'weight'">Weight: {{product.weight}}</p>
        <p v-if="product.productType.require === 'size'">Size: {{product.size}}</p>
        <p v-if="product.productType.require === 'dimensions'">Dimensions: {{product.dimensions}}</p>
      </div>

    </div>

  </div>


</div>

</body>


<script>
  const app = Vue.createApp({
    data() {
      return {
        products: [],
        deleteCheckbox: []
      };
    },
    beforeCreate() {
      axios.get('/api/products' + window.location.search)
          .then((res) => {
            this.products = res.data
          })
    },

    methods: {
      addToDeleteCheckbox(id) {
        let idx = this.deleteCheckbox.findIndex((i) => i === id)
        if(idx >= 0) {
          this.deleteCheckbox.splice(idx, 1)
        } else {
          this.deleteCheckbox.push(id)
        }
      },
      deleteMany() {
        if(this.deleteCheckbox.length === 0) {
          return;
        }
        axios.post('/api/products/bulk-delete?ids=' + this.deleteCheckbox.join(','))
            .then((res) => {
              if(res.data.count > 0) {
                this.products = this.products.filter(obj => !this.deleteCheckbox.includes(obj.id))
                this.deleteCheckbox = []
              }
            })
      },
      goToAddPage() {
        window.location.href = "/products/create"
      }
    }
  });

  app.mount('#app');
</script>
</html>
