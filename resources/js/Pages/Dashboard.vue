<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { reactive } from "vue";
import axios from "axios";

const data = reactive({
  newProduct: {
    product_name: "",
    product_desc: "",
    product_price: 0,
    product_image: "",
  },
  products: [],
  editingProduct: null,
});

const fetchProducts = async () => {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/products");
    data.products = response.data.data;
  } catch (error) {
    console.error(
      "Error fetching products:",
      error.response ? error.response.data : error.message
    );
  }
};

const createProduct = async () => {
  try {
    const response = await axios.post(
      "http://127.0.0.1:8000/api/products",
      data.newProduct,
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    data.products.push(response.data.data);
    data.newProduct = {
      product_name: "",
      product_desc: "",
      product_price: 0,
      product_image: "",
    };
    console.log("Product created successfully:", response.data);
  } catch (error) {
    console.error(
      "Error creating product:",
      error.response ? error.response.data : error.message
    );
  }
};

const editProduct = async (product) => {
  console.log('Editing product:', product); // Check if this log appears
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/products/${product.id}`);
    console.log('Product details fetched:', response.data.data); // Check the fetched data
    data.editingProduct = response.data.data;
  } catch (error) {
    console.error('Error fetching product details:', error.response ? error.response.data : error.message);
  }
};


const updateProduct = async () => {
  if (!data.editingProduct) return;

  try {
    const response = await axios.put(
      `http://127.0.0.1:8000/api/products/${data.editingProduct.id}`,
      data.editingProduct,
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    const index = data.products.findIndex((p) => p.id === data.editingProduct.id);
    if (index !== -1) {
      data.products[index] = response.data.data;
    }
    data.editingProduct = null;
    console.log("Product updated successfully:", response.data);
  } catch (error) {
    console.error(
      "Error updating product:",
      error.response ? error.response.data : error.message
    );
  }
};

const deleteProduct = async (productId) => {
  try {
    await axios.delete(`http://127.0.0.1:8000/api/products/${productId}`);
    data.products = data.products.filter((p) => p.id !== productId);
    console.log("Product deleted successfully");
  } catch (error) {
    console.error(
      "Error deleting product:",
      error.response ? error.response.data : error.message
    );
  }
};

// Fetch products when component is mounted
fetchProducts();
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <!-- Create Product Form -->
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Create New Product</h3>
            <form @submit.prevent="createProduct" class="space-y-4">
              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <input
                  v-model="data.newProduct.product_name"
                  placeholder="Product Name"
                  required
                  class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
                <input
                  v-model="data.newProduct.product_price"
                  type="number"
                  placeholder="Product Price"
                  required
                  class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
              </div>
              <textarea
                v-model="data.newProduct.product_desc"
                placeholder="Product Description"
                class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
              ></textarea>
              <input
                v-model="data.newProduct.product_image"
                placeholder="Product Image URL"
                class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
              />
              <button
                type="submit"
                class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg transition duration-200"
              >
                Create Product
              </button>
            </form>
            <div v-if="data.editingProduct" class="mt-8 p-6 bg-gray-100 rounded-lg">
              <h3 class="text-xl font-semibold mb-4 text-gray-700">Edit Product</h3>
              <form @submit.prevent="updateProduct" class="space-y-4">
                <!-- Form fields with v-model binding -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                  <input
                    v-model="data.editingProduct.product_name"
                    placeholder="Product Name"
                    required
                    class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                  />
                  <input
                    v-model="data.editingProduct.product_price"
                    type="number"
                    placeholder="Product Price"
                    required
                    class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                  />
                </div>
                <textarea
                  v-model="data.editingProduct.product_desc"
                  placeholder="Product Description"
                  class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                ></textarea>
                <input
                  v-model="data.editingProduct.product_image"
                  placeholder="Product Image URL"
                  class="block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
                <button
                  type="submit"
                  class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg transition duration-200"
                >
                  Update Product
                </button>
                <button
                  type="button"
                  @click="data.editingProduct = null"
                  class="w-full sm:w-auto bg-gray-500 hover:bg-gray-600 text-white py-3 px-6 rounded-lg transition duration-200"
                >
                  Cancel
                </button>
              </form>
            </div>

            <!-- Product List -->
            <h3 class="text-xl font-semibold mt-8 mb-4 text-gray-700">Product List</h3>
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Name
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Price
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="product in data.products" :key="product.id">
                  <td class="px-6 py-4 whitespace-nowrap">{{ product.product_name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ product.product_price }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <button
                      @click="editProduct(product)"
                      class="text-blue-500 hover:text-blue-700"
                    >
                      Edit
                    </button>
                    <button
                      @click="deleteProduct(product.id)"
                      class="text-red-500 hover:text-red-700 ml-4"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

          
            <!-- Edit Product Form -->
           
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
