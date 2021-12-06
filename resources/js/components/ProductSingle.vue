<template>
  <div id="AdmCont">
    <fieldset v-if="step == 1" class="fieldset">
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
    </fieldset>
    <fieldset v-if="step == 2" class="fieldset">
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
          <div>
            <h3>Technical title</h3>
            <p>Catch customers' attention with a title .</p>
            <div class="flex-box">
              <input
                type="text"
                class="_inp_admn mbl_inp_100"
                placeholder="eg. Wooden Vup 3 x 3,"
                v-model="metas[0].title"
                maxlength="60"
                minlength="6"
              /><span class="input-counter">{{ 60 - metas[0].title.length }}</span>
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
    </fieldset>
    <!-- Add Thumbnail -->
    <fieldset v-if="step == 3" class="fieldset">
      <div>
        <h2 class="typography-headline4 mb-s mclr">Add Photos</h2>
        <p class="typography-body1 mb-m">
          Upload high-quality photos to show buyers exactly what your products look like.
        </p>
        <div class="thumb-upload">
          <div v-if="metas[0].thumbnail">
            <div class="img-preview round_c_s">
              <img
                class="imagethumb"
                v-bind:src="`${$siteURL}/images/product/small/` + metas[0].thumbnail"
              />
            </div>
          </div>
          <div class="upload-wrapper" v-else>
            <input
              type="file"
              id="thumb"
              class="upload-thumbnail-input"
              accept="image/x-png,image/jpeg"
              @change="uploadColor($event, 0)"
            />
            <div class="drag-text">
              <label for="thumb">
                <svg
                  width="80px"
                  height="80px"
                  viewBox="0 0 48 48"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <title>ONE-xicons</title>
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
                <p>Drag and drop a file or select add Image</p>
              </label>
            </div>
          </div>
          <template v-if="metas[0].colors.length > 0">
            <div class="dflx clr-btn" style="margin: 10px 0">
              <button
                class="sc-selector"
                v-for="(color, i) in metas[0].colors[0]"
                :key="i"
                :style="{ background: color.hex }"
                :class="{ checked: metas[0].color === color.hex }"
                @click.prevent="changeColor(color.hex)"
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
                :style="{ background: metas[0].color }"
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
                  v-bind:value="metas[0].color"
                  class="sc-selector"
                  type="color"
                  @change="colorChangeInput"
                />
              </label>
            </div>
          </template>
        </div>
        <div class="mt-s">
          <div>
            <h3>Upload at least {{ 3 - metas[0].images.length }} more photos</h3>
            <p>Show details, usability, compare, and close-up details of the product.</p>
          </div>
          <div>
            <div class="_UPD_wrap">
              <div
                class="_UPD_preview round_c_s"
                v-for="img in metas[0].images"
                v-bind:key="img.image"
              >
                <img
                  class="imagethumb"
                  v-bind:src="`${$siteURL}/images/product/small/` + img"
                />
              </div>
              <div class="upload-wrapper">
                <input
                  multiple
                  type="file"
                  id="_veriations"
                  class="upload-thumbnail-input"
                  accept="image/x-png,image/jpeg"
                  @change="uploadDetails"
                />
                <div class="drag-text">
                  <label for="_veriations">
                    <svg
                      width="80px"
                      height="80px"
                      viewBox="0 0 48 48"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <title>ONE-xicons</title>
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
                    <p>Drag and drop a file or select add Image</p>
                  </label>
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
    </fieldset>

    <!-- Description -->
    <fieldset v-if="step == 4" class="fieldset">
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
    </fieldset>

    <fieldset v-if="step == 5" class="fieldset">
      <div>
        <div>
          <div>
            <h1 class="typography-headline4 mb-s mclr">Technical Details</h1>
            <p>This details will help buyrs to more deep into your product.</p>
          </div>
          <div>
            <div>
              <h3>Size</h3>
              <div v-if="metas[0]">
                <select
                  class="_inp_admn mbl_inp_100"
                  name=""
                  id=""
                  v-model="metas[0].size"
                >
                  <option v-for="size in sizes" :value="size.code" :key="size.code">
                    {{ size.name }}
                  </option>
                </select>
              </div>
              <div class="mt-m mb-m" v-if="materials.length > 0">
                <h3>Materials</h3>
                <multiselect
                  v-model="metas[0].material"
                  tag-placeholder="Add this as new tag"
                  placeholder="Search or add a collection"
                  label="name"
                  track-by="code"
                  :options="materials"
                  :multiple="true"
                  :taggable="true"
                ></multiselect>
              </div>
              <div>
                <div>
                  <h3>Technical Guides.</h3>
                  <p>Add your own fields</p>
                </div>
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
    </fieldset>

    <!-- Cost -->
    <fieldset v-if="step == 6" class="fieldset">
      <div>
        <div>
          <div>
            <h2 class="typography-headline4 mb-s mclr">Inventory and pricing</h2>
            <p>How much you charge is entirely up to you.</p>
            <div class="flex_align_center">
              <span style="position: absolute; padding: 10px">{{ currency }}</span>
              <input
                type="number"
                placeholder="Price or your product"
                value=""
                v-model="metas[0].price"
                v-on:input="calculateProfit"
                class="_inp_padMax _inp_admn mbl_inp_100"
              />
            </div>

            <div>
              <span>Your Earning</span>
              <input
                type="text"
                disabled
                placeholder="Profit you'll make"
                value=""
                v-model="profit"
                class="input-noninteractive"
              />
            </div>
            <div class="mt-m">
              <div>
                <h3>Quantity</h3>
                <label for="">Quantity to check avaibility</label>
                <div class="flex-box">
                  <button
                    class="input-button-symbol"
                    @click.prevent="decreaseStock"
                    :disabled="metas[0].stock <= 1"
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
                      class="feather feather-minus"
                    >
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                  </button>
                  <select v-model="metas[0].stock">
                    <option v-for="y in 1000" :value="y" :key="y">{{ y }}</option>
                  </select>
                  <button class="input-button-symbol" @click.prevent="increaseStock">
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
                  </button>
                </div>
              </div>
            </div>
            <div>
              <div class="mt-s">
                <div>
                  <h3>SKU (Stock Keeping Unit)</h3>
                  <p>
                    SKUs are for managing your inventory to easily identify the product.
                  </p>
                </div>
                <input
                  type="text"
                  value=""
                  v-model="metas[0].SKU"
                  class="_inp_admn mbl_inp_100"
                />
                <button class="btn-normalize btn-secondary" @click="genereateSKU">
                  Generate
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
    </fieldset>

    <!-- Shipping Details -->
    <fieldset v-if="step == 8" class="fieldset">
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
    </fieldset>

    <!-- Other Details -->
    <fieldset v-if="step == 7" class="fieldset">
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
    </fieldset>

    <fieldset v-if="step == 9" class="fieldset">
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
    </fieldset>
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
      step: 6,
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
      varitaionNames: ["color", "size", "material"],
      isUpdatabale: false,
      studioSections: [],
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
  methods: {
    addCollection() {
      this.newColBox = !this.newColBox;
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
    removeTechField(i) {
      console.log(i);
      this.technical.details.splice(i, 1);
    },
    addMetaData() {
      this.metas.push({
        color: null,
        thumbnail: null,
        size: "M",
        price: null,
        material: [],
        stock: 1,
        colors: [],
        images: [],
        SKU: "",
        title: "",
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

    changeColor(hex) {
      this.metas[0].color = hex;
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

    async uploadColor(e, i) {
      console.log(e.target.files[0]);
      let imageData = new FormData();
      imageData.append("image", e.target.files[0]);
      axios
        .post(this.$siteURL + "/studio/product/thumb/upload", imageData, {
          onUploadProgress: (progressEvent) => {
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
        })
        .catch((error) => {
          console.log(error);
        });
      this.canUpdate();
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    uploadDetails(e) {
      let formData = new FormData();

      for (var i = 0; i < e.target.files.length; i++) {
        formData.append("files[" + i + "]", e.target.files[i]);
      }
      axios
        .post(this.$siteURL + "/studio/product/details/upload", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          // this.details = res.data.images;
          res.data.images.forEach((e) => {
            // console.log(e);
            this.metas[0].images.push(e);
          });
          console.log(res.data.images);
        })
        .catch((error) => {
          console.log(error);
        });
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
          window.location.href = this.$siteURL + "/studio/product-list";
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
<style>
.fieldset {
  padding: 15px;
  border: solid 1px var(--gray-medium);
}
.upload-thumbnail-input {
  position: absolute;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  outline: none;
  opacity: 0;
  cursor: pointer;
}

.imagethumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.color-picker {
  width: 36px;
  height: 36px;
}
.color-picker:after {
  width: 36px;
  height: 36px;
  border-radius: 15px;
  top: -2px;
  left: -1px;
  position: relative;
  content: "";
  display: inline-block;
  visibility: visible;
  border: 2px solid white;
}
.color-picker:checked:after {
  position: relative;
  content: "";
  display: inline-block;
  visibility: visible;
  border: 2px solid rgb(0, 0, 0);
}
.clr-btn .checked svg {
  visibility: visible;
  stroke: white !important;
}
.clr-btn svg {
  visibility: hidden;
}
.sc-selector {
  border-radius: 50%;
  height: 50px;
  width: 50px;
  border: none;
  display: block;
  cursor: pointer;
}
input[type="color"] {
  visibility: hidden;
}
.dflx {
  display: flex;
}
.bnd-col-pick {
  display: flex;
  align-items: center;
}
._UPD_wrap {
  display: flex;
  flex-wrap: wrap;
  flex-shrink: 0;
}
._UPD_preview {
  display: flex;
  width: calc(calc(100% / 2) - 20px);
  flex: 0 0 auto;
  display: flex;
  margin: 0 10px 10px 10px;
}
.ship_adr_box {
  padding: 10px;
}
</style>
