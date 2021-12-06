<template>
  <div>
    <div v-if="step == 1" class="fieldset">
      <h3 class="typography-headline4 mb-s mclr">
        What kind of product are you listing?
      </h3>
      <div>
        <span class="typography-headline6 fw8 mb-s mclr">Choose a department</span>
        <p class="mclr typography-caption">
          Selecting accurate section helps customers to find your product easily.
        </p>
        <select
          class="_inp_admn mbl_inp_100"
          name="section"
          id="section"
          @change="indexCategory"
          v-model="secSelect"
        >
          <option value="0" disabled selected>Select your option</option>
          <option v-for="s in sections" v-bind:key="s.id" v-bind:value="s.id">
            {{ s.name }}
          </option>
        </select>
      </div>

      <div v-if="categories.length > 0">
        <span class="typography-headline6 fw8 mb-s mclr"
          >Let's narrow down the category</span
        >
        <p class="mclr typography-caption">
          Selecting accurate section helps customers to find your product easily.
        </p>
        <select
          class="_inp_admn mbl_inp_100"
          name="category"
          id="category"
          @change="indexSubCategory"
          v-model="subSelect"
        >
          <option disabled value="0">Please select one</option>
          <option v-for="c in categories" v-bind:key="c.id" v-bind:value="c.id">
            {{ c.name }}
          </option>
        </select>
      </div>
      <div v-if="subSelect > 0">
        <span class="typography-headline6 fw8 mb-s mclr"
          >Now, let's get More Specific</span
        >
        <p class="mclr typography-caption">
          Selecting accurate section helps customers to find your product easily.
        </p>
        <select
          class="_inp_admn mbl_inp_100"
          name="subcategories"
          id="subcategories"
          @change="selectCategory"
          v-model="category"
        >
          <option value="0" disabled selected>Select your option</option>
          <option v-for="t in subcategories" v-bind:key="t.id" v-bind:value="t.id">
            {{ t.name }}
          </option>
        </select>
      </div>
      <div class="add-btn-wrap">
        <span></span>
        <button
          :disabled="!category"
          @click.prevent="next()"
          class="btn-normalize btn-third"
        >
          Next
        </button>
      </div>
    </div>
    <div v-if="step == 2" class="fieldset">
      <div>
        <div>
          <div>
            <h2 class="typography-headline4 mb-s mclr">
              Create a name for your product.
            </h2>
            <div>
              <label for="name">Name for your product</label>
            </div>
            <div class="flex-box">
              <input
                class="_inp_admn mbl_inp_100"
                type="text"
                id="name"
                placeholder="eg. Pot, Vash"
                v-model="name"
                maxlength="20"
                minlength="3"
                name="style"
              />
              <span class="input-counter">{{ 20 - name.length }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="add-btn-wrap">
        <button @click.prevent="prev()" class="btn-normalize btn-secondary">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-arrow-left"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline></svg
          >Back
        </button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </div>
    </div>
    <!-- Varient -->
    <div v-if="step == 3" class="fieldset">
      <div>
        <h2 class="typography-headline4 mb-s mclr">Inventory</h2>
        <p class="typography-body1 mb-m">
          Upload high-quality photos to show buyers exactly what your products look like.
        </p>
        <div>
          <div>
            <button @click="variantBox = true" class="btn-normalize btn-secondary">
              <span v-if="variations.length == 0"> Add variations </span>
              <span v-else>Edit variations</span>
            </button>
          </div>
        </div>
        <div
          v-if="metas.length > 0"
          style="width: 100%; overflow-x: auto; min-height: 200px"
        >
          <table class="_inv_table mt-m">
            <tr>
              <td>
                <div class="_v_head">
                  <span> Thumb </span>
                  <button
                    v-if="
                      metas.length > 1 &&
                      selectedVariation.length == 1 &&
                      selectedVariation[0] == 'size'
                    "
                    class="_v_copy"
                    @click="copyThumb"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      x="0px"
                      y="0px"
                      viewBox="0 0 210.107 210.107"
                      fill="none"
                      stroke-width="2"
                    >
                      <path
                        style="fill: #1d1d1b"
                        d="M168.506,0H80.235C67.413,0,56.981,10.432,56.981,23.254v2.854h-15.38
		c-12.822,0-23.254,10.432-23.254,23.254v137.492c0,12.822,10.432,23.254,23.254,23.254h88.271
		c12.822,0,23.253-10.432,23.253-23.254V184h15.38c12.822,0,23.254-10.432,23.254-23.254V23.254C191.76,10.432,181.328,0,168.506,0z
		 M138.126,186.854c0,4.551-3.703,8.254-8.253,8.254H41.601c-4.551,0-8.254-3.703-8.254-8.254V49.361
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.253,3.703,8.253,8.254V186.854z M176.76,160.746
		c0,4.551-3.703,8.254-8.254,8.254h-15.38V49.361c0-12.822-10.432-23.254-23.253-23.254H71.981v-2.854
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.254,3.703,8.254,8.254V160.746z"
                      />
                    </svg>
                  </button>
                </div>
              </td>
              <td>Color</td>
              <td>
                <div class="_v_head">
                  <span> Title </span>
                  <button v-if="metas.length > 1" class="_v_copy" @click="copyTitle">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      x="0px"
                      y="0px"
                      viewBox="0 0 210.107 210.107"
                      fill="none"
                      stroke-width="2"
                    >
                      <path
                        style="fill: #1d1d1b"
                        d="M168.506,0H80.235C67.413,0,56.981,10.432,56.981,23.254v2.854h-15.38
		c-12.822,0-23.254,10.432-23.254,23.254v137.492c0,12.822,10.432,23.254,23.254,23.254h88.271
		c12.822,0,23.253-10.432,23.253-23.254V184h15.38c12.822,0,23.254-10.432,23.254-23.254V23.254C191.76,10.432,181.328,0,168.506,0z
		 M138.126,186.854c0,4.551-3.703,8.254-8.253,8.254H41.601c-4.551,0-8.254-3.703-8.254-8.254V49.361
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.253,3.703,8.253,8.254V186.854z M176.76,160.746
		c0,4.551-3.703,8.254-8.254,8.254h-15.38V49.361c0-12.822-10.432-23.254-23.253-23.254H71.981v-2.854
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.254,3.703,8.254,8.254V160.746z"
                      />
                    </svg>
                  </button>
                </div>
              </td>
              <td>Size</td>
              <td>
                <div class="_v_head">
                  <span> Material </span>

                  <button v-if="metas.length > 1" class="_v_copy" @click="copyMaterial">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      x="0px"
                      y="0px"
                      viewBox="0 0 210.107 210.107"
                      fill="none"
                      stroke-width="2"
                    >
                      <path
                        style="fill: #1d1d1b"
                        d="M168.506,0H80.235C67.413,0,56.981,10.432,56.981,23.254v2.854h-15.38
		c-12.822,0-23.254,10.432-23.254,23.254v137.492c0,12.822,10.432,23.254,23.254,23.254h88.271
		c12.822,0,23.253-10.432,23.253-23.254V184h15.38c12.822,0,23.254-10.432,23.254-23.254V23.254C191.76,10.432,181.328,0,168.506,0z
		 M138.126,186.854c0,4.551-3.703,8.254-8.253,8.254H41.601c-4.551,0-8.254-3.703-8.254-8.254V49.361
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.253,3.703,8.253,8.254V186.854z M176.76,160.746
		c0,4.551-3.703,8.254-8.254,8.254h-15.38V49.361c0-12.822-10.432-23.254-23.253-23.254H71.981v-2.854
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.254,3.703,8.254,8.254V160.746z"
                      />
                    </svg>
                  </button>
                </div>
              </td>
              <td>
                <div class="_v_head">
                  <span> Stock </span>

                  <button v-if="metas.length > 1" class="_v_copy" @click="copyMaterial">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      x="0px"
                      y="0px"
                      viewBox="0 0 210.107 210.107"
                      fill="none"
                      stroke-width="2"
                    >
                      <path
                        style="fill: #1d1d1b"
                        d="M168.506,0H80.235C67.413,0,56.981,10.432,56.981,23.254v2.854h-15.38
		c-12.822,0-23.254,10.432-23.254,23.254v137.492c0,12.822,10.432,23.254,23.254,23.254h88.271
		c12.822,0,23.253-10.432,23.253-23.254V184h15.38c12.822,0,23.254-10.432,23.254-23.254V23.254C191.76,10.432,181.328,0,168.506,0z
		 M138.126,186.854c0,4.551-3.703,8.254-8.253,8.254H41.601c-4.551,0-8.254-3.703-8.254-8.254V49.361
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.253,3.703,8.253,8.254V186.854z M176.76,160.746
		c0,4.551-3.703,8.254-8.254,8.254h-15.38V49.361c0-12.822-10.432-23.254-23.253-23.254H71.981v-2.854
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.254,3.703,8.254,8.254V160.746z"
                      />
                    </svg>
                  </button>
                </div>
              </td>
              <td>
                <div class="_v_head">
                  <span> SKU </span>

                  <button v-if="metas.length > 1" class="_v_copy" @click="copyMaterial">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      x="0px"
                      y="0px"
                      viewBox="0 0 210.107 210.107"
                      fill="none"
                      stroke-width="2"
                    >
                      <path
                        style="fill: #1d1d1b"
                        d="M168.506,0H80.235C67.413,0,56.981,10.432,56.981,23.254v2.854h-15.38
		c-12.822,0-23.254,10.432-23.254,23.254v137.492c0,12.822,10.432,23.254,23.254,23.254h88.271
		c12.822,0,23.253-10.432,23.253-23.254V184h15.38c12.822,0,23.254-10.432,23.254-23.254V23.254C191.76,10.432,181.328,0,168.506,0z
		 M138.126,186.854c0,4.551-3.703,8.254-8.253,8.254H41.601c-4.551,0-8.254-3.703-8.254-8.254V49.361
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.253,3.703,8.253,8.254V186.854z M176.76,160.746
		c0,4.551-3.703,8.254-8.254,8.254h-15.38V49.361c0-12.822-10.432-23.254-23.253-23.254H71.981v-2.854
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.254,3.703,8.254,8.254V160.746z"
                      />
                    </svg>
                  </button>
                </div>
              </td>
              <td>
                <div class="_v_head">
                  <span> Price </span>

                  <button v-if="metas.length > 1" class="_v_copy" @click="copyPrice">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      x="0px"
                      y="0px"
                      viewBox="0 0 210.107 210.107"
                      fill="none"
                      stroke-width="2"
                    >
                      <path
                        style="fill: #1d1d1b"
                        d="M168.506,0H80.235C67.413,0,56.981,10.432,56.981,23.254v2.854h-15.38
		c-12.822,0-23.254,10.432-23.254,23.254v137.492c0,12.822,10.432,23.254,23.254,23.254h88.271
		c12.822,0,23.253-10.432,23.253-23.254V184h15.38c12.822,0,23.254-10.432,23.254-23.254V23.254C191.76,10.432,181.328,0,168.506,0z
		 M138.126,186.854c0,4.551-3.703,8.254-8.253,8.254H41.601c-4.551,0-8.254-3.703-8.254-8.254V49.361
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.253,3.703,8.253,8.254V186.854z M176.76,160.746
		c0,4.551-3.703,8.254-8.254,8.254h-15.38V49.361c0-12.822-10.432-23.254-23.253-23.254H71.981v-2.854
		c0-4.551,3.703-8.254,8.254-8.254h88.271c4.551,0,8.254,3.703,8.254,8.254V160.746z"
                      />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            <!-- /No Varient -->
            <!-- for varient -->
            <template v-if="metas.length > 1">
              <tbody v-for="(m, index) in metas" :key="index">
                <tr>
                  <td v-if="m.thumbnail">
                    <img
                      class="round_c_s"
                      :src="`${$siteURL}/images/product/thumb/` + m.thumbnail"
                      alt=""
                    />
                  </td>
                  <td v-else>
                    <input
                      type="file"
                      id="thumb"
                      accept="image/x-png,image/jpeg"
                      @change="uploadSingleColor($event, index)"
                    />
                  </td>
                  <td>
                    <button
                      class="sc-selector"
                      :style="{ background: m.color }"
                      @click.prevent=""
                    ></button>
                  </td>
                  <td><input type="text" name="" id="" v-model="m.title" /></td>
                  <td>{{ m.size }}</td>
                  <td v-if="materials">
                    <multiselect
                      v-model="m.material"
                      tag-placeholder="Add this as new tag"
                      placeholder="Add materials"
                      label="name"
                      track-by="code"
                      :options="materials"
                      :multiple="true"
                      :taggable="true"
                    ></multiselect>
                  </td>
                  <td><input type="number" v-model="m.stock" /></td>
                  <td><input type="text" v-model="m.sku" /></td>
                  <td>
                    <span>{{ currency }}({{ symbol }})</span
                    ><input type="text" v-model="m.price" />
                  </td>
                  <button @click.prevent="deleteMeta(index)">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="feather feather-trash-2"
                    >
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path
                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                      ></path>
                      <line x1="10" y1="11" x2="10" y2="17"></line>
                      <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                  </button>
                </tr>
                <tr>
                  <td colspan="8">
                    <div>
                      <h3>Upload at least {{ 3 - m.images.length }} more images</h3>
                    </div>
                    <div class="flex-box _up_vars">
                      <div v-for="img in m.images" v-bind:key="img.image">
                        <img
                          class="imagethumb"
                          v-bind:src="`${$siteURL}/images/product/thumb/` + img"
                        />
                      </div>
                      <div class="upload-wrapper">
                        <label :for="`_up_img` + index">
                          <input
                            :disabled="isUploading"
                            multiple
                            type="file"
                            class="upload-thumbnail-input"
                            accept="image/x-png,image/jpeg"
                            @change="uploadDetails($event, index)"
                            :id="`_up_img` + index"
                          />
                          <div class="up_dt_img0">
                            <svg
                              v-if="!isUploading"
                              width="80px"
                              height="80px"
                              viewBox="0 0 48 48"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M42.21,36.75l-36.42,0a0.79,0.79,0,0,1-.7-0.42,0.77,0.77,0,0,1,0-.8L13.29,25a0.78,0.78,0,0,1,.63-0.32,0.85,0.85,0,0,1,.65.33l5.19,5.82,9.39-12.79a0.83,0.83,0,0,1,1.31,0L42.86,35.53h0a0.77,0.77,0,0,1,0,.79A0.79,0.79,0,0,1,42.21,36.75Zm-36-1,35.56,0-12-16.85L20.41,31.66a0.78,0.78,0,0,1-.63.33,0.8,0.8,0,0,1-.66-0.33l-5.19-5.83ZM19.6,31.07v0Zm0.29,0h0Zm-6.11-5.36h0Zm0.31,0,0,0Zm15.53-7h0Zm0.34,0v0Z"
                              ></path>
                              <path
                                d="M19,21.25h0a5,5,0,0,1,0-10h0A5,5,0,0,1,19,21.25Zm0-9a4,4,0,0,0,0,8h0a4,4,0,0,0,0-8h0Z"
                              ></path>
                              <path
                                d="M43.5,45H4.5A4.5,4.5,0,0,1,0,40.5V7.5A4.5,4.5,0,0,1,4.5,3h39A4.5,4.5,0,0,1,48,7.5v33A4.5,4.5,0,0,1,43.5,45ZM4.5,4A3.5,3.5,0,0,0,1,7.5v33A3.5,3.5,0,0,0,4.5,44h39A3.5,3.5,0,0,0,47,40.5V7.5A3.5,3.5,0,0,0,43.5,4H4.5Z"
                              ></path>
                              <rect width="48" height="48" fill="none"></rect>
                            </svg>
                            <svg
                              v-else
                              width="80px"
                              height="80px"
                              version="1.1"
                              id="Layer_1"
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              x="0px"
                              y="0px"
                              viewBox="0 0 512 512"
                              style="enable-background: new 0 0 512 512"
                              xml:space="preserve"
                            >
                              <path
                                d="M256,0c-10.345,0-18.732,8.387-18.732,18.732v92.994c0,10.345,8.387,18.732,18.732,18.732s18.732-8.387,18.732-18.732
				V18.732C274.732,8.387,266.345,0,256,0z"
                              />
                              <path
                                d="M256,381.542c-10.345,0-18.732,8.387-18.732,18.732v92.994c0,10.345,8.387,18.732,18.732,18.732
				s18.732-8.387,18.732-18.732v-92.994C274.732,389.929,266.345,381.542,256,381.542z"
                              />
                              <path
                                d="M140.42,167.64l-80.535-46.497c-8.959-5.172-20.416-2.103-25.588,6.857c-5.172,8.959-2.103,20.415,6.856,25.589
				l80.535,46.497c8.96,5.172,20.416,2.102,25.588-6.856C152.45,184.27,149.38,172.814,140.42,167.64z"
                              />
                              <path
                                d="M470.846,358.411l-80.535-46.497c-8.96-5.172-20.416-2.103-25.587,6.856c-5.172,8.959-2.103,20.415,6.856,25.588
				l80.535,46.497c8.96,5.172,20.416,2.102,25.588-6.857C482.875,375.041,479.805,363.585,470.846,358.411z"
                              />
                              <path
                                d="M121.689,311.915l-80.535,46.497c-8.959,5.172-12.028,16.629-6.856,25.589c5.175,8.962,16.633,12.027,25.588,6.857
				l80.535-46.497c8.959-5.172,12.028-16.629,6.856-25.588C142.105,309.812,130.647,306.742,121.689,311.915z"
                              />
                              <path
                                d="M390.311,200.085l80.535-46.497c8.959-5.172,12.028-16.629,6.856-25.589c-5.172-8.959-16.629-12.03-25.588-6.857
				l-80.535,46.497c-8.959,5.172-12.028,16.629-6.856,25.589C369.898,202.191,381.355,205.256,390.311,200.085z"
                              />
                            </svg>
                          </div>
                        </label>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </template>
            <!-- No Varient -->
            <template v-else>
              <tbody v-for="(m, index) in metas" :key="index">
                <tr>
                  <td v-if="m.thumbnail">
                    <div>
                      <img
                        class="round_c_s"
                        :src="`${$siteURL}/images/product/thumb/` + m.thumbnail"
                        alt=""
                      />
                      <span @click="deleteThumb">Delete</span>
                    </div>
                  </td>
                  <td v-else>
                    <input
                      type="file"
                      id="thumb"
                      accept="image/x-png,image/jpeg"
                      @change="uploadSingleColor($event, index)"
                    />
                  </td>
                  <td>
                    <button
                      class="sc-selector"
                      :style="{ background: m.color }"
                      @click.prevent=""
                    ></button>
                  </td>
                  <td><input type="text" name="" id="" v-model="m.title" /></td>
                  <td>
                    <select name="m_size" id="single_size" v-model="m.size">
                      <option v-for="(sz, si) in sizes" :key="si" :value="sz.code">
                        {{ sz.name }}
                      </option>
                    </select>
                  </td>
                  <td v-if="materials">
                    <multiselect
                      v-model="m.material"
                      tag-placeholder="Add this as new tag"
                      placeholder="Add materials"
                      label="name"
                      track-by="code"
                      :options="materials"
                      :multiple="true"
                      :taggable="true"
                    ></multiselect>
                  </td>
                  <td><input type="number" v-model="m.stock" /></td>
                  <td><input type="text" v-model="m.sku" /></td>
                  <td>
                    <span>{{ currency }}({{ symbol }})</span
                    ><input type="number" v-model="m.price" />
                  </td>
                </tr>
                <tr>
                  <td colspan="8">
                    <div>
                      <h3>Upload at least {{ 3 - m.images.length }} more images</h3>
                    </div>
                    <div class="flex-box _up_vars">
                      <div v-for="img in m.images" v-bind:key="img.image">
                        <img
                          class="imagethumb"
                          v-bind:src="`${$siteURL}/images/product/thumb/` + img"
                        />
                      </div>
                      <div class="upload-wrapper">
                        <label for="_up_img">
                          <input
                            :disabled="isUploading"
                            multiple
                            type="file"
                            class="upload-thumbnail-input"
                            accept="image/x-png,image/jpeg"
                            @change="uploadDetails($event, index)"
                            id="_up_img"
                          />
                          <div class="up_dt_img0">
                            <svg
                              v-if="!isUploading"
                              width="80px"
                              height="80px"
                              viewBox="0 0 48 48"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M42.21,36.75l-36.42,0a0.79,0.79,0,0,1-.7-0.42,0.77,0.77,0,0,1,0-.8L13.29,25a0.78,0.78,0,0,1,.63-0.32,0.85,0.85,0,0,1,.65.33l5.19,5.82,9.39-12.79a0.83,0.83,0,0,1,1.31,0L42.86,35.53h0a0.77,0.77,0,0,1,0,.79A0.79,0.79,0,0,1,42.21,36.75Zm-36-1,35.56,0-12-16.85L20.41,31.66a0.78,0.78,0,0,1-.63.33,0.8,0.8,0,0,1-.66-0.33l-5.19-5.83ZM19.6,31.07v0Zm0.29,0h0Zm-6.11-5.36h0Zm0.31,0,0,0Zm15.53-7h0Zm0.34,0v0Z"
                              ></path>
                              <path
                                d="M19,21.25h0a5,5,0,0,1,0-10h0A5,5,0,0,1,19,21.25Zm0-9a4,4,0,0,0,0,8h0a4,4,0,0,0,0-8h0Z"
                              ></path>
                              <path
                                d="M43.5,45H4.5A4.5,4.5,0,0,1,0,40.5V7.5A4.5,4.5,0,0,1,4.5,3h39A4.5,4.5,0,0,1,48,7.5v33A4.5,4.5,0,0,1,43.5,45ZM4.5,4A3.5,3.5,0,0,0,1,7.5v33A3.5,3.5,0,0,0,4.5,44h39A3.5,3.5,0,0,0,47,40.5V7.5A3.5,3.5,0,0,0,43.5,4H4.5Z"
                              ></path>
                              <rect width="48" height="48" fill="none"></rect>
                            </svg>
                            <svg
                              v-else
                              width="80px"
                              height="80px"
                              version="1.1"
                              id="Layer_1"
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              x="0px"
                              y="0px"
                              viewBox="0 0 512 512"
                              style="enable-background: new 0 0 512 512"
                              xml:space="preserve"
                            >
                              <path
                                d="M256,0c-10.345,0-18.732,8.387-18.732,18.732v92.994c0,10.345,8.387,18.732,18.732,18.732s18.732-8.387,18.732-18.732
				V18.732C274.732,8.387,266.345,0,256,0z"
                              />
                              <path
                                d="M256,381.542c-10.345,0-18.732,8.387-18.732,18.732v92.994c0,10.345,8.387,18.732,18.732,18.732
				s18.732-8.387,18.732-18.732v-92.994C274.732,389.929,266.345,381.542,256,381.542z"
                              />
                              <path
                                d="M140.42,167.64l-80.535-46.497c-8.959-5.172-20.416-2.103-25.588,6.857c-5.172,8.959-2.103,20.415,6.856,25.589
				l80.535,46.497c8.96,5.172,20.416,2.102,25.588-6.856C152.45,184.27,149.38,172.814,140.42,167.64z"
                              />
                              <path
                                d="M470.846,358.411l-80.535-46.497c-8.96-5.172-20.416-2.103-25.587,6.856c-5.172,8.959-2.103,20.415,6.856,25.588
				l80.535,46.497c8.96,5.172,20.416,2.102,25.588-6.857C482.875,375.041,479.805,363.585,470.846,358.411z"
                              />
                              <path
                                d="M121.689,311.915l-80.535,46.497c-8.959,5.172-12.028,16.629-6.856,25.589c5.175,8.962,16.633,12.027,25.588,6.857
				l80.535-46.497c8.959-5.172,12.028-16.629,6.856-25.588C142.105,309.812,130.647,306.742,121.689,311.915z"
                              />
                              <path
                                d="M390.311,200.085l80.535-46.497c8.959-5.172,12.028-16.629,6.856-25.589c-5.172-8.959-16.629-12.03-25.588-6.857
				l-80.535,46.497c-8.959,5.172-12.028,16.629-6.856,25.589C369.898,202.191,381.355,205.256,390.311,200.085z"
                              />
                            </svg>
                          </div>
                        </label>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </template>
          </table>
        </div>
      </div>
      <div v-if="variantBox" class="_SVsf">
        <div class="_SO_overlay"></div>
        <div>
          <div class="_SO_card">
            <div class="_SO_dialog round_c_b">
              <div class="_SO_d_t">
                <button @click.prevent="closeVarient" class="_SO_d_bx">X</button>
                <h3 class="mt-s mb-s">Add variations</h3>
              </div>
              <div class="_SO_d_b">
                <div class="mb-m">
                  <span>List all the options you offer.</span>
                </div>

                <div v-if="variations.length == 0">
                  <div>
                    <label for="_var"><strong>Add a variation</strong></label>
                  </div>
                  <div>
                    <select id="_var" @change="createVariation($event)">
                      <option value="0" disabled selected>Choose variation type</option>
                      <option v-for="(vs, vin) in unlisted" :key="vin" :value="vs">
                        {{ vs }}
                      </option>
                    </select>
                  </div>
                </div>
                <div v-if="variations.length > 0">
                  <div v-for="(d, v) in variations" :key="v">
                    <div class="mt-m mb-m" v-if="d.type == 'color'">
                      <div>
                        <div>
                          <strong>Color</strong>
                          <button @click.prevent="deleteVariation(v)">Delete</button>
                        </div>
                        <div class="mb-m" v-for="(c, index) in d.thumb" :key="index">
                          <div class="flex-box">
                            <img
                              class="round_c_s"
                              :src="`${$siteURL}/images/product/thumb/` + c"
                            />
                            <a @click.prevent="deleteVariantThumb(v, index)"
                              ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-trash"
                              >
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                  d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                                ></path></svg
                            ></a>
                          </div>

                          <div>
                            <div class="dflx clr-btn mt-s">
                              <button
                                class="sc-selector"
                                v-for="(color, i) in d.colors[index]"
                                :key="i"
                                :style="{ background: color.hex }"
                                :class="{ checked: color.hex == d.data[index] }"
                                @click.prevent="changeColor(color.hex, index, v)"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  width="24"
                                  height="24"
                                  viewBox="0 0 24 24"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                >
                                  <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                              </button>
                              <label
                                class="sc-selector bnd-col-pick"
                                :style="{ background: color }"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  width="24"
                                  height="24"
                                  viewBox="0 0 24 24"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  class="pik-ico"
                                >
                                  <path
                                    d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"
                                  ></path>
                                </svg>
                                <input
                                  v-bind:value="color"
                                  class="sc-selector"
                                  type="color"
                                />
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="mt-m">
                          <div class="upload-wrapper">
                            <label :for="`_up_img` + v">
                              <input
                                :disabled="isUploading"
                                multiple
                                type="file"
                                class="upload-thumbnail-input"
                                accept="image/x-png,image/jpeg"
                                @change="uploadColor($event, v)"
                                :id="`_up_img` + v"
                              />
                              <div class="up_dt_img0">
                                <svg
                                  v-if="!isUploading"
                                  width="80px"
                                  height="80px"
                                  viewBox="0 0 48 48"
                                  xmlns="http://www.w3.org/2000/svg"
                                >
                                  <path
                                    d="M42.21,36.75l-36.42,0a0.79,0.79,0,0,1-.7-0.42,0.77,0.77,0,0,1,0-.8L13.29,25a0.78,0.78,0,0,1,.63-0.32,0.85,0.85,0,0,1,.65.33l5.19,5.82,9.39-12.79a0.83,0.83,0,0,1,1.31,0L42.86,35.53h0a0.77,0.77,0,0,1,0,.79A0.79,0.79,0,0,1,42.21,36.75Zm-36-1,35.56,0-12-16.85L20.41,31.66a0.78,0.78,0,0,1-.63.33,0.8,0.8,0,0,1-.66-0.33l-5.19-5.83ZM19.6,31.07v0Zm0.29,0h0Zm-6.11-5.36h0Zm0.31,0,0,0Zm15.53-7h0Zm0.34,0v0Z"
                                  ></path>
                                  <path
                                    d="M19,21.25h0a5,5,0,0,1,0-10h0A5,5,0,0,1,19,21.25Zm0-9a4,4,0,0,0,0,8h0a4,4,0,0,0,0-8h0Z"
                                  ></path>
                                  <path
                                    d="M43.5,45H4.5A4.5,4.5,0,0,1,0,40.5V7.5A4.5,4.5,0,0,1,4.5,3h39A4.5,4.5,0,0,1,48,7.5v33A4.5,4.5,0,0,1,43.5,45ZM4.5,4A3.5,3.5,0,0,0,1,7.5v33A3.5,3.5,0,0,0,4.5,44h39A3.5,3.5,0,0,0,47,40.5V7.5A3.5,3.5,0,0,0,43.5,4H4.5Z"
                                  ></path>
                                  <rect width="48" height="48" fill="none"></rect>
                                </svg>
                                <svg
                                  v-else
                                  width="80px"
                                  height="80px"
                                  version="1.1"
                                  id="Layer_1"
                                  xmlns="http://www.w3.org/2000/svg"
                                  xmlns:xlink="http://www.w3.org/1999/xlink"
                                  x="0px"
                                  y="0px"
                                  viewBox="0 0 512 512"
                                  style="enable-background: new 0 0 512 512"
                                  xml:space="preserve"
                                >
                                  <path
                                    d="M256,0c-10.345,0-18.732,8.387-18.732,18.732v92.994c0,10.345,8.387,18.732,18.732,18.732s18.732-8.387,18.732-18.732
				V18.732C274.732,8.387,266.345,0,256,0z"
                                  />
                                  <path
                                    d="M256,381.542c-10.345,0-18.732,8.387-18.732,18.732v92.994c0,10.345,8.387,18.732,18.732,18.732
				s18.732-8.387,18.732-18.732v-92.994C274.732,389.929,266.345,381.542,256,381.542z"
                                  />
                                  <path
                                    d="M140.42,167.64l-80.535-46.497c-8.959-5.172-20.416-2.103-25.588,6.857c-5.172,8.959-2.103,20.415,6.856,25.589
				l80.535,46.497c8.96,5.172,20.416,2.102,25.588-6.856C152.45,184.27,149.38,172.814,140.42,167.64z"
                                  />
                                  <path
                                    d="M470.846,358.411l-80.535-46.497c-8.96-5.172-20.416-2.103-25.587,6.856c-5.172,8.959-2.103,20.415,6.856,25.588
				l80.535,46.497c8.96,5.172,20.416,2.102,25.588-6.857C482.875,375.041,479.805,363.585,470.846,358.411z"
                                  />
                                  <path
                                    d="M121.689,311.915l-80.535,46.497c-8.959,5.172-12.028,16.629-6.856,25.589c5.175,8.962,16.633,12.027,25.588,6.857
				l80.535-46.497c8.959-5.172,12.028-16.629,6.856-25.588C142.105,309.812,130.647,306.742,121.689,311.915z"
                                  />
                                  <path
                                    d="M390.311,200.085l80.535-46.497c8.959-5.172,12.028-16.629,6.856-25.589c-5.172-8.959-16.629-12.03-25.588-6.857
				l-80.535,46.497c-8.959,5.172-12.028,16.629-6.856,25.589C369.898,202.191,381.355,205.256,390.311,200.085z"
                                  />
                                </svg>
                              </div>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-if="d.type == 'size'">
                      <div>
                        <div class="mt-m">
                          <div>
                            <strong>Size</strong
                            ><button @click.prevent="deleteVariation(v)">Delete</button>
                          </div>

                          <select class="mt-m" @change="addSizeVariation(v, $event)">
                            <option value="0" disabled selected>
                              Select size option
                            </option>
                            <option
                              v-for="(sz, sin) in unlistedSizes"
                              :key="sin"
                              :value="sz.code"
                            >
                              {{ sz.name }}
                            </option>
                          </select>
                        </div>
                        <div
                          style="width: 100%; justify-content: space-between"
                          class="flex-box mt-s mb-s"
                          v-for="(s, y) in d.data"
                          :key="y"
                        >
                          <span style="min-width: 150px">{{ s }}</span>
                          <button @click="deleteVariantSize(v, y)">
                            <svg
                              data-v-75b34476=""
                              xmlns="http://www.w3.org/2000/svg"
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              class="feather feather-trash"
                            >
                              <polyline
                                data-v-75b34476=""
                                points="3 6 5 6 21 6"
                              ></polyline>
                              <path
                                data-v-75b34476=""
                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                              ></path>
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mt-m mb-m" v-if="variations.length == 1">
                    <div>
                      <label for="_var"><strong>Add a variation</strong></label>
                    </div>
                    <div>
                      <select id="_var" @change="createVariation($event)">
                        <option value="0" disabled selected>Choose variation type</option>
                        <option v-for="(vs, vin) in unlisted" :key="vin" :value="vs">
                          {{ vs }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div
                style="
                  padding: 15px;
                  display: flex;
                  justify-content: space-between;
                  width: 100%;
                  box-sizing: border-box;
                "
              >
                <span></span>
                <button
                  class="btn-normalize btn-third"
                  :disabled="!isUpdatabale"
                  @click.prevent="updateVariations(variations)"
                >
                  Update
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-btn-wrap">
        <button @click.prevent="prev()" class="btn-normalize btn-secondary">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-arrow-left"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline></svg
          >Back
        </button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </div>
    </div>
    <!-- /Varient -->

    <!-- Description -->
    <div v-if="step == 4" class="fieldset">
      <div>
        <div>
          <div>
            <h3 class="typography-headline4 mb-s mclr">Describe your product</h3>
            <p>
              Description is a chance to inspire customer to buy your product. Think like
              story. Description should give detail information about your product.
            </p>
            <ul>
              <li>Briefly describe the details</li>
              <li>Get specific, tell what is unique about your product</li>
              <li>Why, and how your product was made</li>
              <li>Tell a story, what your product meant to you</li>
            </ul>
            <textarea
              v-model="description"
              style="width: 100%"
              cols="30"
              rows="10"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="add-btn-wrap">
        <button @click.prevent="prev()" class="btn-normalize btn-secondary">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-arrow-left"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline></svg
          >Back
        </button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </div>
    </div>

    <div v-if="step == 5" class="fieldset">
      <div>
        <div>
          <div>
            <h1 class="typography-headline4 mb-s mclr">Technical Details</h1>
            <p>This details will help buyrs to more deep into your product.</p>
          </div>
          <div>
            <div>
              <div>
                <div>
                  <div>
                    <input
                      class="_inp_admn mbl_inp_100"
                      type="text"
                      name="header"
                      id="header"
                      v-model="technical.title"
                      placeholder="Title of your guide"
                    />
                    <button @click.prevent="addHeader">Add Headers</button>
                  </div>
                  <div class="flex-box">
                    <div v-for="(header, index) in technical.headers" :key="index">
                      <input
                        class="_up_td_inp"
                        type="text"
                        v-model="technical.headers[index]"
                      />
                    </div>
                  </div>
                  <div>
                    <div
                      v-for="(detail, index) in technical.details"
                      :key="index"
                      class="flex-box"
                    >
                      <div v-for="(field, i) in detail" :key="i">
                        <auto-text-area
                          class="_up_td_inp"
                          v-model="technical.details[index][i]"
                        ></auto-text-area>
                      </div>
                      <div>
                        <button @click="removeTechField(index)">
                          ({{ index }})Remove
                        </button>
                      </div>
                    </div>
                  </div>
                  <div v-if="technical.headers.length > 0">
                    <button @click.prevent="addFields">Add Fields</button>
                  </div>
                </div>
                <div>
                  <table>
                    <tr>
                      <td v-for="(header, index) in technical.headers" :key="index">
                        <strong>{{ header }}</strong>
                      </td>
                    </tr>
                    <tr v-for="(detail, index) in technical.details" :key="index">
                      <td v-for="(field, i) in detail" :key="i">
                        {{ technical.details[index][i] }}
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div></div>
          </div>
        </div>
      </div>
      <div class="add-btn-wrap">
        <button @click.prevent="prev()" class="btn-normalize btn-secondary">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-arrow-left"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline></svg
          >Back
        </button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </div>
    </div>

    <!-- Shipping Details -->
    <div v-if="step == 6" class="fieldset">
      <div>
        <div>
          <h3 class="typography-headline4 mb-s mclr">Shipping</h3>

          <div>
            <h4>Processing time</h4>
            <article>
              How long does it take you to prepare, package, and dispatch? (after buyers
              placed an order).
            </article>
            <select
              class="_inp_admn"
              name="Origin"
              id="Origin"
              @change="indexCategory"
              v-model="days"
            >
              <option v-for="n in 60" v-bind:key="n" v-bind:value="n">
                {{ n }}
              </option>
            </select>
            Business days
          </div>

          <div
            style="display: flex; flex-direction: column"
            v-if="shippingAddresses.length > 0"
          >
            <div
              class="flex-box ship_addr_card"
              v-for="(address, index) in shippingAddresses"
              :key="index"
            >
              <div>
                <select
                  class="_inp_admn mbl_inp_100"
                  name="Deliver"
                  id="Deliver"
                  @change="indexCategory"
                  v-model="address.country_name"
                >
                  <option value="EVR">Everywhere</option>
                  <option
                    v-for="deliver in countries"
                    v-bind:key="deliver.code"
                    v-bind:value="deliver.code"
                  >
                    {{ deliver.name }}
                  </option>
                </select>
                <div>
                  <div v-if="address.country_name == 'NP'">
                    <div>
                      <select
                        class="_inp_admn mbl_inp_100"
                        name="Deliver"
                        id="Deliver"
                        v-model="address.city"
                      >
                        <option value="everywhere">Everywhere</option>
                        <option
                          v-for="d in destricts"
                          v-bind:key="d.code"
                          v-bind:value="d.name"
                        >
                          {{ d.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div>
                    <div>
                      <input
                        type="checkbox"
                        name=""
                        :id="index + '_charge'"
                        v-model="address.free"
                      />
                      <label :for="index + '_charge'">Free shipping?</label>
                    </div>
                    <div class="flex-box" v-if="!address.free">
                      <div class="ship_price_box">
                        <div>
                          <label :for="address.country_name + '_' + index"
                            >One item</label
                          >
                        </div>
                        <div class="flex_align_center">
                          <span class="ship_price_symbol"> {{ symbol }}</span>

                          <input
                            class="inp_sml _inp_admn"
                            type="number"
                            placeholder="Price"
                            value=""
                            :id="address.country_name + '_' + index"
                            v-model="address.primary_cost"
                          />
                        </div>
                      </div>
                      <div>
                        <div>
                          <label :for="address.country_name + '_' + index + '_s'"
                            >Aditional item</label
                          >
                        </div>
                        <div class="flex_align_center">
                          <span class="ship_price_symbol"> {{ symbol }}</span>
                          <input
                            class="inp_sml _inp_admn"
                            type="number"
                            placeholder="Price"
                            value=""
                            :id="address.country_name + '_' + index + '_s'"
                            v-model="address.secondary_cost"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                <button class="ship_rmv_btn" @click="removeAddress(index)">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-trash"
                  >
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path
                      d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <div>
            <button
              class="btn-normalize btn-secondary"
              @click="addShippingAddress('EVR')"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-plus"
              >
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
              <span>Add another location</span>
            </button>
          </div>
        </div>
      </div>
      <div class="add-btn-wrap">
        <button @click.prevent="prev()" class="btn-normalize btn-secondary">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-arrow-left"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline></svg
          >Back
        </button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </div>
    </div>

    <!-- Other Details -->
    <div v-if="step == 7" class="fieldset">
      <div>
        <div>
          <div>
            <h2 class="typography-headline4 mb-s mclr">Additional Informations</h2>
            <p>
              Commission enables buyers to order a product/item even after it is been sold
              out.
            </p>
            <!-- Comission -->
            <div>
              <div>
                Enabling commission will allow buyers to order same product or customized
                when you're out of stock.
              </div>
              <div>
                <input type="checkbox" id="commission" v-model="commission" />
                <label for="commission">Yes, I accept commission for this product</label>
              </div>
            </div>

            <!-- Customization -->
            <div>
              <div>
                <h3>Customization</h3>
                <p>
                  Customization will allow user to order product according to their needs.
                </p>
                <div>
                  <input type="checkbox" id="customization" v-model="customization" />
                  <label for="customization">Allow, Customization</label>
                  <div>
                    <div v-if="customization">
                      <div>Message to the person ordering</div>
                      <textarea v-model="custommessage" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-btn-wrap">
        <button @click.prevent="prev()" class="btn-normalize btn-secondary">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-arrow-left"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline></svg
          >Back
        </button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </div>
    </div>

    <div v-if="step == 8" class="fieldset">
      <div>
        <div>
          <h3 class="typography-headline4 mb-s mclr">You’re ready to publish!</h3>
          <p>
            You’ll be able to welcome your first guest starting April 4, 2021. If you’d
            like to update your calendar or house rules, you can easily do all that after
            you hit publish.
          </p>
          <div class="mt-m mb">
            <h3>Collection</h3>
            <div>
              <select v-model="newCol" class="_inp_admn mbl_inp_100" name="" id="">
                <option value="0">None</option>
                <option v-for="sec in studioSections" :key="sec.id" :value="sec.id">
                  {{ sec.name }}
                </option>
              </select>
              <div class="mt-m">
                <button class="btn-normalize ship_col_new_un" @click="addCollection">
                  <span>New Collection</span>
                </button>
              </div>
              <div>
                <div v-if="newColBox">
                  <input class="_inp_admn mbl_inp_100" type="text" v-model="collection" />
                  <div>
                    <button class="btn-normalize btn-secondary" @click="saveCollection">
                      Save
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-btn-wrap">
        <button @click.prevent="prev()" class="btn-normalize btn-secondary">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-arrow-left"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline></svg
          >Back
        </button>
        <button @click.prevent="save()" class="btn-normalize btn-third">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";
import Vibrant from "node-vibrant";
import * as Color from "../Color";
import AutoTextArea from "./AutoTextArea.vue";
import Multiselect from "vue-multiselect";
export default {
  data() {
    return {
      collection: "",
      newCol: 0,
      destricts: [],
      preColor: [],
      color: null,
      step: 1,
      category_id: "",
      name: "",
      description: "",
      meta_title: "",
      meta_description: "",
      is_featured: "",
      profit: null,
      technical: {
        headers: [],
        title: null,
        details: [],
        fields: [],
      },
      variantBox: false,
      materials: null,
      days: 1,
      metas: [],
      categories: [],
      subcategories: [],
      sections: [],
      category: 0,
      subSelect: 0,
      secSelect: 0,
      subcategory: 0,
      commission: false,
      customization: false,
      custommessage: "",
      countries: [],
      origin: "NP",
      elsewhere: 0,
      newColBox: false,
      shippingAddresses: [],
      thumbnail: {
        image: null,
      },
      sizes: null,
      variations: [],
      selectedVariation: [],
      selectedSizes: [],
      varitaionNames: ["color", "size"],
      isUpdatabale: false,
      studioSections: [],
      isUploading: false,
    };
  },
  components: {
    AutoTextArea,
    Multiselect,
  },
  props: {
    studioid: Number,
    symbol: String,
    currency: String,
  },
  computed: {
    unlisted: function () {
      return this.varitaionNames.filter((x) => !this.selectedVariation.includes(x));
    },
    unlistedSizes: function () {
      return this.sizes.filter((s) => !this.selectedSizes.includes(s.code));
    },
  },
  methods: {
    addCollection() {
      this.newColBox = !this.newColBox;
    },
    deleteMeta(index) {
      this.metas.splice(index, 1);
    },
    createVariation(event) {
      var v = event.target.value;
      console.log(v);
      if (!this.selectedVariation.includes(v)) {
        this.selectedVariation.push(v);
      } else {
        return;
      }

      if (v == "color") {
        this.variations.push({
          data: [],
          thumb: [],
          colors: [],
          type: "color",
        });
      } else if (v == "material") {
        this.variations.push({
          data: [],
          type: "material",
        });
      } else if (v == "size") {
        this.variations.push({
          data: [],
          type: "size",
        });
      }
    },
    saveCollection() {
      if (this.collection.length >= 3) {
        let collData = new FormData();
        collData.append("collection", this.collection);
        axios
          .post(this.$siteURL + "/studio/post/collection", collData)
          .then((res) => {
            this.collection = "";
            this.newColBox = false;

            this.studioSections.push(res.data);

            this.newCol = res.data.id;

            this.$toast.success("'" + res.data.name + "' added to your collection.", {
              position: "top-center",
              timeout: 3000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          })
          .catch((err) => {
            if (err.response.status == 429) {
              this.$toast.error("Collection already exists!", {
                position: "top-center",
                timeout: 3000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
                rtl: false,
              });
            } else {
              this.$toast.error("Something went wrong!", {
                position: "top-center",
                timeout: 3000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
                rtl: false,
              });
            }
          });
      } else {
        this.$toast.error("Error! min length 3 character.", {
          position: "top-center",
          timeout: 3000,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: true,
          closeButton: "button",
          icon: true,
          rtl: false,
        });
      }
    },
    addSection() {
      console.log("FUCK");
    },
    increaseStock() {
      this.metas[0].stock++;
    },
    decreaseStock() {
      if (this.metas[0].stock > 1) {
        this.metas[0].stock--;
      }
    },
    prev() {
      this.step--;
    },
    next() {
      this.step++;
    },
    addHeader() {
      // console.log(this.technical.title);
      this.technical.headers.push("");
    },
    addFields() {
      this.technical.fields = [];
      this.technical.headers.forEach((element) => {
        this.technical.fields.push("");
      });
      this.technical.details.push(this.technical.fields);
    },
    addSizeVariation(i, event) {
      var v = event.target.value;
      this.variations[i].data.push(v);
      this.selectedSizes.push(v);
      this.canUpdate();
    },
    removeTechField(i) {
      console.log(i);
      this.technical.details.splice(i, 1);
    },
    addMetaData(
      color = null,
      thumbnail = null,
      size = "M",
      price = 0,
      material = [],
      stock = 1,
      colors = [],
      images = [],
      sku = "",
      title = ""
    ) {
      this.metas.push({
        color: color,
        thumbnail: thumbnail,
        size: size,
        price: price,
        material: material,
        stock: stock,
        colors: colors,
        images: images,
        SKU: sku,
        title: title,
      });
    },
    addShippingAddress(country = "0") {
      this.shippingAddresses.push({
        page_id: this.studioid,
        country_name: country,
        city: "everywhere",
        primary_cost: 0,
        secondary_cost: 0,
        delivery_time: 5,
        shipping_carrer_id: 0,
        country_code: 0,
        free: false,
      });
    },
    removeAddress(i) {
      console.log(i);
      this.shippingAddresses.splice(i, 1);
    },
    canUpdate() {
      if (this.variations.length > 0) {
        this.variations.forEach((v) => {
          if (v.data.length > 0) {
            this.isUpdatabale = true;
          } else {
            this.isUpdatabale = false;
          }
        });
      } else {
        this.isUpdatabale = false;
      }
    },

    colorChangeInput(e) {
      var c = e.target.value;

      this.metas[0].color = this.getNearestDefinedColor(c);
    },

    getNearestDefinedColor(c) {
      var colNewList = {};
      const [L1, A1, B1] = Color.HEX2LAB(c, 1);

      for (var i = 0; i < this.preColor.length; i++) {
        for (var j = 0; j < this.preColor[i].length; j++) {
          const [L2, A2, B2] = Color.HEX2LAB(this.preColor[i][j], 2);
          colNewList[this.preColor[i][j]] = Color.DeltaE00(L1, A1, B1, L2, A2, B2);
        }
      }
      let key = Object.keys(colNewList).reduce((key, v) =>
        colNewList[v] < colNewList[key] ? v : key
      );
      return key;
    },

    changeColor(hex, did, vid) {
      console.log(hex + did + vid);
      console.log(this.variations[vid].data[did]);
      this.variations[vid].data.splice(did, 1, hex);
    },
    updateVariations() {
      this.clearMetaData();
      switch (this.variations.length) {
        case 1:
          this.variations.forEach((v) => {
            if (v.type == "size") {
              v.data.forEach((e) => {
                this.addMetaData(
                  null, //color
                  null, //thumb
                  e, //size
                  0, //price
                  [], //material
                  1, // stock
                  [], //colors
                  [], //images
                  "", //sku
                  "" //title
                );
              });
            } else if (v.type == "color") {
              v.data.forEach((e, ind) => {
                this.addMetaData(
                  e, //color
                  v.thumb[ind], //thumb
                  "M", //size
                  0, //price
                  [], //material
                  1, // stock
                  v.colors[ind], //colors
                  [], //images
                  "", //sku
                  "" //title
                );
              });
            }
          });
          break;
        case 2:
          for (let i = 0; i < this.variations[0].data.length; i++) {
            for (let j = 0; j < this.variations[1].data.length; j++) {
              console.log(this.variations[0].type + this.variations[1].type);
              if (
                this.variations[0].type == "color" &&
                this.variations[1].type == "size"
              ) {
                this.addMetaData(
                  this.variations[0].data[i], //color
                  this.variations[0].thumb[i], //thumb
                  this.variations[1].data[j], //size
                  0, //price
                  [], //material
                  1, //stock
                  "BLUE", //colors
                  [], //images
                  "", //sku
                  "" //title
                );
              } else if (
                this.variations[0].type == "size" &&
                this.variations[1].type == "color"
              ) {
                this.addMetaData(
                  this.variations[1].data[j], //color
                  this.variations[1].thumb[j], //thumb
                  this.variations[0].data[i], //size
                  0, //price
                  [], //material
                  1, //stock
                  "BLUE", //colors
                  [], //images
                  "", //sku
                  "" //title
                );
              }
            }
          }
          break;
      }
    },
    clearMetaData() {
      this.metas = [];
    },
    copyMaterial() {
      this.metas.forEach((m, i) => {
        if (i > 0) {
          this.metas[i].material = this.metas[0].material;
        }
      });
    },
    copyThumb() {
      this.metas.forEach((m, i) => {
        if (i > 0) {
          this.metas[i].thumbnail = this.metas[0].thumbnail;
          this.metas[i].color = this.metas[0].color;
          this.metas[i].colors = this.metas[0].colors;
        }
      });
    },
    copyPrice() {
      this.metas.forEach((m, i) => {
        if (i > 0) {
          this.metas[i].price = this.metas[0].price;
        }
      });
    },
    copyTitle() {
      this.metas.forEach((m, i) => {
        if (i > 0) {
          this.metas[i].title = this.metas[0].title;
        }
      });
    },
    copySKU() {
      this.metas.forEach((m, i) => {
        if (i > 0) {
          this.metas[i].title = this.metas[0].title;
        }
      });
    },
    deleteVariation(i) {
      console.log(i);
      this.variations.splice(i, 1);
      this.selectedVariation.splice(i, 1);
    },
    deleteVariantThumb(i, t) {
      this.variations[i].colors.splice(t, 1);
      this.variations[i].thumb.splice(t, 1);
      this.variations[i].data.splice(t, 1);
    },
    deleteVariantSize(i, t) {
      this.variations[i].data.splice(t, 1);
      this.selectedSizes.splice(t, 1);
    },
    deleteThumb() {
      this.metas[0].thumbnail = null;
      this.metas[0].color = null;
      this.metas[0].colors = [];
    },
    async uploadSingleColor(e, i) {
      let imageData = new FormData();
      imageData.append("image", e.target.files[0]);
      axios
        .post(this.$siteURL + "/studio/product/thumb/upload", imageData, {
          onUploadProgress: (progressEvent) => {
            this.isUploading = true;
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
            );
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
            );
          },
        })
        .then((res) => {
          this.metas[i].thumbnail = res.data.image;
          Vibrant.from(this.$siteURL + "/images/product/small/" + res.data.image)
            .maxColorCount(200)
            .getPalette()
            .then((palette) => {
              const colors = [];
              var number = 0;
              for (let color in palette) {
                const hex = this.getNearestDefinedColor(palette[color].getHex());
                colors.push({
                  hex,
                });
              }
              console.log(colors);
              this.metas[i].color = colors[0].hex;
              this.metas[i].colors.push(colors);
            });
          this.isUploading = false;
        })
        .catch((error) => {
          this.isUploading = false;
          if (error.response.status == 405) {
            this.$toast.error("Invalid image aspected ratio", {
              position: "top-center",
              timeout: 5000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          } else {
            this.$toast.error("Something went wrong.", {
              position: "top-center",
              timeout: 3000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          }
        });
      this.canUpdate();
    },
    async uploadColor(e, i) {
      console.log(i);
      let imageData = new FormData();
      imageData.append("image", e.target.files[0]);
      axios
        .post(this.$siteURL + "/studio/product/thumb/upload", imageData, {
          onUploadProgress: (progressEvent) => {
            this.isUploading = true;
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
            );
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
            );
          },
        })
        .then((res) => {
          this.variations[i].thumb.push(res.data.image);
          Vibrant.from(this.$siteURL + "/images/product/small/" + res.data.image)
            .maxColorCount(200)
            .getPalette()
            .then((palette) => {
              const colors = [];
              var number = 0;
              for (let color in palette) {
                const hex = palette[color].getHex();
                colors.push({
                  hex,
                });
              }
              this.variations[i].colors.push(colors);
              this.variations[i].data.push(colors[0].hex);
            });
          this.isUploading = false;
        })
        .catch((error) => {
          this.isUploading = false;
          if (error.response.status == 405) {
            this.$toast.error("Invalid image aspected ratio", {
              position: "top-center",
              timeout: 5000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          } else {
            this.$toast.error("Something went wrong.", {
              position: "top-center",
              timeout: 3000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          }
        });
      this.canUpdate();
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    uploadDetails(e, metaid) {
      let formData = new FormData();

      for (var i = 0; i < e.target.files.length; i++) {
        formData.append("files[" + i + "]", e.target.files[i]);
      }
      axios
        .post(this.$siteURL + "/studio/product/details/upload", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
          onUploadProgress: (progressEvent) => {
            this.isUploading = true;
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
            );
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
            );
          },
        })
        .then((res) => {
          res.data.images.forEach((e) => {
            this.metas[metaid].images.push(e);
          });
          this.isUploading = false;
        })
        .catch((error) => {
          this.isUploading = false;
          if (error.response.status == 405) {
            this.$toast.error("Invalid image aspected ratio", {
              position: "top-center",
              timeout: 5000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          } else {
            this.$toast.error("Something went wrong.", {
              position: "top-center",
              timeout: 3000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          }
        });
    },
    closeVarient() {
      this.variantBox = false;
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    indexCategory(e) {
      this.subSelect = 0;
      axios.get(this.$siteURL + "/categories/" + e.target.value).then((result) => {
        this.categories = result.data;
        console.log(this.categories);
      });
    },
    indexSubCategory(e) {
      this.category = 0;
      axios
        .get(this.$siteURL + "/categories/" + e.target.value + "/sub")
        .then((result) => {
          this.subcategories = result.data;
          console.log(this.subcategories);
        });
    },
    selectCategory(e) {
      this.category = e.target.value;
    },
    removeVarient(i, type) {
      if (type == size) {
        this.shippingAddresses.splice(i, 1);
      }
    },
    onSubmit() {
      axios.post("/page/aproducts", this.$data).then((res) => {
        this.inputs[index] = res.data;
      });
    },
    genereateSKU() {
      this.metas[0].SKU = Math.random().toString(30).slice(5).toUpperCase();
    },
    save() {
      let pData = new FormData();
      pData.append("category", this.category);
      pData.append("secSelect", this.secSelect);
      pData.append("name", this.name);
      pData.append("description", this.description);
      pData.append("commission", this.commission);
      pData.append("customization", this.customization);
      pData.append("custommessage", this.custommessage);
      pData.append("collection_id", this.newCol);
      pData.append("metas", JSON.stringify(this.metas));
      pData.append("technical", JSON.stringify(this.technical));
      pData.append("shipping", JSON.stringify(this.shippingAddresses));
      pData.append("processing_time", this.days);
      axios
        .post(this.$siteURL + "/studio/list/create", pData)
        .then((res) => {
          this.$toast.success("'" + res.data.name + "' created! wait for approvel.", {
            position: "top-center",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
          // window.location.href = this.$siteURL + "/studio/product-list";
        })
        .catch((err) => {
          this.$toast.error("Something went wrong! recheck the form", {
            position: "top-center",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
        });
    },
    calculateProfit(e) {
      this.profit =
        Number(this.metas[0].price) - (Number(this.metas[0].price) * 15) / 100;
    },
    SortByName(x, y) {
      return x.name == y.name ? 0 : x.name > y.name ? 1 : -1;
    },
  },
  created() {
    axios.get(this.$siteURL + "/api/categories").then((result) => {
      this.sections = result.data;
    });

    axios.get(this.$siteURL + "/js/filter/color.json").then((result) => {
      this.preColor = result.data;
    });

    axios.get(this.$siteURL + "/js/filter/materials.json").then((result) => {
      this.materials = result.data;
    });

    axios.get(this.$siteURL + "/js/filter/sizes.json").then((result) => {
      this.sizes = result.data;
    });

    axios.get(this.$siteURL + "/js/country/countries.json").then((result) => {
      this.countries = result.data;
    });
    axios.get(this.$siteURL + "/js/districts/districts.json").then((result) => {
      this.destricts = result.data;
      this.destricts.sort(this.SortByName);
    });
    Vibrant.from();
  },
  mounted() {
    this.addMetaData();
    this.addShippingAddress(this.origin);
    this.addShippingAddress("EVR");
    // get sections
    axios
      .get(this.$siteURL + "/studio/get/collection")
      .then((res) => {
        res.data.forEach((e) => {
          this.studioSections.push(e);
        });
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
<style scoped>
._inv_table td {
  padding: 6px;
}
.fieldset {
  width: calc(100% - 250px);
  border: none;
  box-sizing: border-box;
}
@media only screen and (max-width: 600px) {
  .fieldset {
    width: 100%;
  }
}
</style>
