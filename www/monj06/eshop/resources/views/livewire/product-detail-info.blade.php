  <div>
      <h1 class="text-3xl font-bold text-neutral-800 mb-2">{{ $product->name }}</h1>

      <div class="mb-6">
          <div class="flex items-baseline">
              <span class="text-2xl font-bold text-primary-600">
                  <p>Price</p>{{ $product->price }}
              </span>

          </div>

          <p class="text-sm text-neutral-600 mt-1">
              <!-- product stock -->
              @if ($product->stock == 0)
                  <span class="text-red-500 font-medium">Out of Stock</span>
              @else
                  <span class="text-forest-500 font-medium">In Stock</span> - {{ $product->stock }} units available
              @endif

          </p>
      </div>

      <div class="mb-6">
          <p class="text-neutral-700">{{ $product->description }}</p>
      </div>

      <!-- Add to Cart -->
      <div class="mb-8">
          <form class="max-w-md mx-auto" action="{{ route('cart.add', $product->id) }}" method="GET">
              <div class="flex items-center mb-4">
                  <label for="quantity" class="mr-4 font-medium">Quantity:</label>
                  <div class="flex items-center">
                      <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1"
                          class="w-16 text-center border-y border-neutral-300 py-2" />
                  </div>
              </div>
              @if ($product->stock == 0)
              @else
                  <div class="flex flex-wrap gap-4">
                      <button type="submit"
                          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                          to cart</button>
                  </div>
              @endif
          </form>
      </div>

      <!-- Shipping & Returns -->
      <div>
          <div class="flex items-center text-neutral-700 mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
              </svg>
              Free shipping on orders over $100
          </div>
          <div class="flex items-center text-neutral-700 mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              30-day hassle-free returns
          </div>
          <div class="flex items-center text-neutral-700">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              2-year warranty
          </div>
      </div>
  </div>
