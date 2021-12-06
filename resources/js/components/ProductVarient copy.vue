<template>
  <div id="AdmCont">
    <form action="" method="get">
      <fieldset v-if="step == 1" class="round_c_m fieldset">
        <h3 class="typography-headline4 mb-m">What kind of product are you listing?</h3>
        <div>
          <span class="typography-headline6 fw8 mb-s mclr">Choose a department</span>
          <p class="mclr typography-caption">
            Selecting accurate section helps customers to find your product easily.
          </p>
          <select name="section" id="section" @change="indexCategory" v-model="secSelect">
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
        <button
          :disabled="!category"
          @click.prevent="next()"
          class="btn-normalize btn-third"
        >
          Next
        </button>
        <div>
          <div v-for="(vs, index) in varitaionNames" :key="index">
            <div v-if="variations.length < 2">
              <div @click.prevent="createVariation(vs)">{{ vs }}</div>
            </div>
            <div v-else>
              <div>{{ vs }}f</div>
            </div>
          </div>
        </div>
        <div v-if="variations.length > 0">
          <div v-for="(d, v) in variations" :key="v">
            <div v-if="d.type == 'color'">
              <div>
                <div>
                  <input
                    type="file"
                    accept="image/jpeg"
                    @change="uploadColor($event, v)"
                  />
                </div>
                <div v-for="(c, index) in d.thumb" :key="index">
                  <img :src="`${$siteURL}/images/product/thumb/` + c" />
                  <div>
                    <div class="dflx clr-btn">
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
                        <input v-bind:value="color" class="sc-selector" type="color" />
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="d.type == 'size'">
              <div>
                <div>
                  Add Size
                  <button @click.prevent="addSizeVariation(v)">Add {{ v }}</button>
                </div>
                <div v-for="s in d.data" :key="s">
                  {{ s }}
                </div>
              </div>
            </div>
            <div v-if="d.type == 'material'">
              <div>
                <div>
                  Add material
                  <button @click.prevent="addMaterialVariation(v)">Add {{ v }}</button>
                </div>
                <div v-for="s in d.data" :key="s">
                  {{ s }}
                </div>
              </div>
            </div>
          </div>
          <div>
            <button
              :disabled="!isUpdatabale"
              @click.prevent="updateVariations(variations)"
            >
              Update
            </button>
          </div>
        </div>
        <table v-if="metas.length > 0">
          <!-- color = null,
      thumbnail = null,
      size = null,
      price = null,
      material = null,
      stock = null,
      colors = null,
      images = null,
      sku = null -->
          <tr>
            <td>Color</td>
            <td>Thumb</td>
            <td>Size</td>
            <td>material</td>
            <td>stock</td>
            <td>images</td>
            <td>sku</td>
            <td>price</td>
          </tr>
          <tr v-for="(m, index) in metas" :key="index">
            <td>
              <button
                class="sc-selector"
                :style="{ background: m.color }"
                @click.prevent=""
              ></button>
            </td>
            <td>
              <img :src="`${$siteURL}/images/product/thumb/` + m.thumbnail" alt="" />
            </td>
            <td><input type="text" v-model="m.size" /></td>
            <td>{{ m.material }}</td>
            <td><input type="number" v-model="m.stock" /></td>
            <td>{{ m.thumb }}</td>
            <td><input type="text" v-model="m.sku" /></td>
            <td><input type="text" v-model="m.price" /></td>
            <button @click.prevent="deleteMeta(index)">X</button>
          </tr>
        </table>
      </fieldset>

      <!-- Add Thumbnail -->
      <fieldset v-if="step == 3" class="round_c_m fieldset">
        <h2 class="typography-headline4 mb-s mclr">Add Photos</h2>
        <p class="typography-body1 mb-m">
          Upload high quality photos to show buyers exactly what your products looks like.
          They will be reviewed by our review team so make sure they meet our photo
          standards.
        </p>
        <div>
          <h3>Requirement</h3>
          <ol class="lst-ol">
            <li>Photos must be clear, bright, and in color</li>
            <li>Photos must be yours, Do not use copyrighted photos</li>
            <li>They must accurately describe your product</li>
          </ol>
        </div>
        <div class="thumb-upload">
          <h3>Cover photo most be in a white background</h3>
          <div class="upload-wrapper">
            <input
              type="file"
              class="upload-thumbnail-input"
              accept="image/x-png,image/jpeg"
              @change="previewFile"
            />
            <div class="drag-text">
              <p>Drag and drop a file or select add Image</p>
            </div>
            <div class="img-preview">
              <img
                class="imagethumb"
                v-if="thumbnail.image"
                v-bind:src="'http://127.0.0.1:8000/images/' + thumbnail.image"
              />
            </div>
          </div>
        </div>
        <div>
          <div>
            <h3>Show a variety of details</h3>
            <p>
              Upload multiple images, show details, compare, usability, in environment and
              close-up details of the product
            </p>
          </div>
          <div>
            <div>
              <div class="upload-wrapper">
                <input
                  multiple
                  type="file"
                  class="upload-thumbnail-input"
                  accept="image/x-png,image/jpeg"
                  @change="uploadDetails"
                />
                <div class="drag-text">
                  <p>Drag and drop a file or select add Image</p>
                </div>
              </div>
            </div>
            <div v-if="details.length > 0">
              <div v-for="img in details" v-bind:key="img.image">
                <img
                  class="imagethumb"
                  v-bind:src="'http://127.0.0.1:8000/images/' + img"
                />
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

      <fieldset v-if="step == 2" class="round_c_m fieldset">
        <div>
          <div>
            <div>
              <h3>Give your product a name</h3>
              <p>Product name should be short and descriptive</p>
              <h4>What is the the name of your product</h4>
              <input type="text" placeholder="Repeat style" v-model="name" name="style" />
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>

      <fieldset v-if="step == 4" class="round_c_m fieldset">
        <div>
          <div>
            <div>
              <h3>Describe your product</h3>
              <p>
                Description is a chance to inspire customer to buy your product. Think
                like story. Description should give detail information about your product.
              </p>
              <h4>How to descripbe product?</h4>
              <ul>
                <li>Briefly describe the details</li>
                <li>Get specific, tell what is unique about your product</li>
                <li>Why, and how your product was made</li>
                <li>Tell a story, what your product meant to you</li>
              </ul>
              <textarea v-model="description" cols="30" rows="10"></textarea>
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>

      <fieldset v-if="step == 5" class="round_c_m fieldset">
        <div>
          <div>
            <div>
              <h3>Are you open to Commission?</h3>
              <p>
                Commission enables buyers to order a product/item even after it is been
                sold out.
              </p>
              <input type="checkbox" id="commission" v-model="commission" />
              <label for="commission">Yes, I accept commission for this product</label>
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>

      <fieldset v-if="step == 6" class="round_c_m fieldset">
        <div>
          <div>
            <div>
              <h3>Customization</h3>
              <p>Collect Customization information for this listing.</p>
              <input type="checkbox" id="customization" v-model="customization" />
              <label for="customization">Allow, Customization</label>
            </div>
            <div v-if="customization">
              <textarea v-model="custommessage" cols="30" rows="10"></textarea>
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>

      <fieldset v-if="step == 7" class="round_c_m fieldset">
        <div>
          <div>
            <div>
              <h3>What is the promary Color of your product?</h3>
              <p>Choose the color of your product.</p>
              <h4>What is the the name of your product</h4>
              <input
                class="color-picker"
                type="radio"
                id="#ffffff"
                value="#ffffff"
                v-model="color"
              />
              <input
                class="color-picker"
                type="radio"
                id="#00ff00"
                value="#00ff00"
                v-model="color"
              />
              <input
                class="color-picker"
                type="radio"
                id="#00ffC9"
                value="#00ffC9"
                v-model="color"
              />
            </div>
            <div>
              <div>
                <h3>Add material used in this product?</h3>
                <p>Falano Dhiskano</p>
                <input
                  type="text"
                  placeholder="Repeat style"
                  v-model="materialField"
                  name="material"
                />
                <button
                  :disabled="materialField.length < 2"
                  @click.prevent="addMaterial"
                  class="btn btn-info"
                >
                  Add Material
                </button>
              </div>
              <div v-if="materials.length > 0">
                <div v-for="mat in materials" v-bind:key="mat">
                  {{ mat }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>

      <fieldset v-if="step == 8" class="round_c_m fieldset">
        <div>
          <div>
            <div>
              <h3>Variations</h3>
              <p>
                This allows you to add variation if your product has a variations like,
                size color or material.
              </p>
              <h4>Add variation</h4>
              <input type="checkbox" id="variation" value="" v-model="addvariation" />
            </div>
            <div v-if="addvariation">
              <h1>Falano dhiskano</h1>
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>

      <fieldset v-if="step == 9" class="round_c_m fieldset">
        <div>
          <div>
            <div>
              <h3>How much do you want to charge per night?</h3>
              <p>How much you charge is entirely up to you.</p>
              <input
                type="text"
                placeholder="Repeat style"
                value=""
                v-model="price"
                v-on:input="calculateProfit"
              />
              <input
                type="text"
                disabled
                placeholder="Repeat style"
                value=""
                v-model="profit"
              />
            </div>
            <div>
              <h3>Affiliate marketing (optional)</h3>
              <p>
                Affiliate marketers will refer customers to this product and earn 15%
                commission
              </p>
              <div>
                <strong>Tip:</strong>60% of the product sell has enabled affiliate
                marketing.
              </div>
              <input
                type="checkbox"
                id="affiliate"
                v-model="affiliate"
                @change="calculateProfit"
              />
              <label for="affiliate">Enable Affiliate marketing</label>
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>

      <fieldset v-if="step == 10" class="round_c_m fieldset">
        <div>
          <div>
            <h3>Shipping</h3>
            <p>Product name should be short and descriptive</p>
            <h4>Origin, Where are you delivering from</h4>
            <select name="Origin" id="Origin" @change="indexCategory" v-model="origin">
              <option value="0" disabled selected>Select your option</option>
              <option
                v-for="country in countries"
                v-bind:key="country.code"
                v-bind:value="country.name"
              >
                {{ country.name }}
              </option>
            </select>
            <div>
              <h4>Origin, Where are you delivering from</h4>
              <select
                name="Deliver"
                id="Deliver"
                @change="indexCategory"
                v-model="origin"
              >
                <option value="0" disabled selected>Select your option</option>
                <option
                  v-for="deliver in countries"
                  v-bind:key="deliver.code"
                  v-bind:value="deliver.name"
                >
                  {{ deliver.name }}
                </option>
              </select>
              Shipping charge
              <input type="text" placeholder="Price" value="" v-model="shippingcharge" />
            </div>
            <div>
              <h4>To other Country</h4>
              <select
                name="Deliver"
                id="Deliver"
                @change="indexCategory"
                v-model="elsewhere"
              >
                <option value="0" disabled selected>Select your option</option>
                <option
                  v-for="deliver in countries"
                  v-bind:key="deliver.code"
                  v-bind:value="deliver.name"
                >
                  {{ deliver.name }}
                </option>
              </select>
              Shipping charge
              <input type="text" placeholder="Price" value="" v-model="shippingcharge" />
            </div>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="next()" class="btn-normalize btn-third">Next</button>
      </fieldset>
      <fieldset v-if="step == 11" class="round_c_m fieldset">
        <div>
          <div>
            <h3>You’re ready to publish!</h3>
            <p>
              You’ll be able to welcome your first guest starting April 4, 2021. If you’d
              like to update your calendar or house rules, you can easily do all that
              after you hit publish.
            </p>
          </div>
        </div>
        <button @click.prevent="prev()" class="btn btn-info">Previous</button>
        <button @click.prevent="save()" class="btn-normalize btn-third">Publish</button>
      </fieldset>
    </form>
  </div>
</template>

<script>
import _ from "lodash";
import Vibrant from "node-vibrant";
import * as Color from "../Color";
export default {
  data() {
    return {
      step: 1,
      category_id: "",
      name: "",
      description: "",
      style: "",
      weight: "",
      discount: "",
      spaciality: "",
      meta_title: "",
      meta_description: "",
      is_featured: "",
      colors: [],
      materials: [],
      materialField: "",
      size: [],
      price: [],
      affiliate: null,
      profit: null,
      stock: [],
      addvariation: null,
      metas: [],
      categories: [],
      subcategories: [],
      sections: [],
      category: 0,
      subSelect: 0,
      secSelect: 0,
      subcategory: 0,
      color: null,
      commission: false,
      customization: false,
      custommessage: "",
      details: [],
      countries: [],
      origin: 0,
      elsewhere: 0,
      shippingcharge: [],
      thumbnail: {
        image: null,
      },
      variations: [],
      selectedVariation: [],
      varitaionNames: ["color", "size", "material"],
      isUpdatabale: false,
    };
  },
  methods: {
    prev() {
      this.step--;
    },
    next() {
      this.step++;
    },
    addMetaData(
      color = null,
      thumbnail = null,
      size = null,
      price = null,
      material = null,
      stock = null,
      colors = null,
      images = null,
      sku = null
    ) {
      this.metas.push({
        color: color,
        thumbnail: thumbnail,
        size: size,
        price: price,
        material: material,
        stock: stock,
        colorsMeta: colors,
        images: images,
        SKU: sku,
      });
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
    updateVariations() {
      this.clearMetaData();
      switch (this.variations.length) {
        case 1:
          this.variations.forEach((v) => {
            v.data.forEach((e) => {
              this.addMetaData("black", "1", 20, 12.66, "Red", true, "BLUE", "FFFF");
            });
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
                  this.variations[0].data[i],
                  "1",
                  this.variations[1].data[j],
                  12.66,
                  "Red",
                  true,
                  "BLUE",
                  "FFFF"
                );
              } else if (
                this.variations[0].type == "material" &&
                this.variations[1].type == "size"
              ) {
                this.addMetaData(
                  "1", //color
                  "", //thumb
                  12.66, //size
                  "Red", //price
                  true, //material
                  "BLUE", //stock
                  "FFFF", //colors
                  "", //images
                  "" //sku
                );
              } else if (
                this.variations[0].type == "color" &&
                this.variations[1].type == "material"
              ) {
                this.addMetaData(
                  this.variations[0].data[i], //color
                  this.variations[0].thumb[i], //thumb
                  12.66, //size
                  50.5, //price
                  this.variations[1].data[j], //material
                  0, //stock
                  "FFFF", //colors
                  "", //images
                  "" //sku
                );
              } else if (
                this.variations[0].type == "material" &&
                this.variations[1].type == "color"
              ) {
                this.addMetaData(
                  this.variations[0].data[i], //color
                  this.variations[0].thumb[i], //thumb
                  12.66, //size
                  50.5, //price
                  this.variations[1].data[j], //material
                  0, //stock
                  "FFFF", //colors
                  "", //images
                  "" //sku
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
    varTOS(v) {
      console.log(Object.keys({ v })[0]);
    },
    deleteMeta(index) {
      this.metas.splice(index, 1);
    },
    createVariation(v) {
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
    changeColor(hex, did, vid) {
      console.log(hex + did + vid);
      console.log(this.variations[vid].data[did]);
      this.variations[vid].data.splice(did, 1, hex);
    },
    async uploadColor(e, i) {
      console.log(i);
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
        })
        .catch((error) => {
          console.log(error);
        });
      this.canUpdate();
    },
    addSizeVariation(i) {
      this.variations[i].data.push("FUCK");
      this.canUpdate();
    },
    addMaterialVariation(i) {
      console.log(i);
      this.variations[i].data.push("FUCK");
      this.canUpdate();
    },
    addMaterial(e) {
      let materialInput = e.target.parentElement.querySelector("input[name=material]");
      this.materials.push(materialInput.value);

      this.materialField = "";
    },
    deleteRow(index) {
      this.inputs.splice(index, 1);
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    previewFile(e) {
      this.thumbnail.image = e.target.files[0];

      let thumbData = new FormData();
      thumbData.append("image", this.thumbnail.image);

      let imp = e.target.parentElement.querySelector(".img-preview");

      axios
        .post("/api/post/thumbnail", thumbData)
        .then((res) => {
          imp.style.display = "block";
          this.thumbnail.image = res.data.image;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    uploadDetails(e) {
      let formData = new FormData();

      for (var i = 0; i < e.target.files.length; i++) {
        formData.append("files[" + i + "]", e.target.files[i]);
      }
      axios
        .post("/api/post/details", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.details = res.data.images;
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
    save() {
      console.log(this.$data);
      axios.post(this.$siteURL + "/page/list/create", this.$data).then((res) => {
        alert(res.data.success);
        // window.location.href = "http://127.0.0.1:8000/page/product-list";
      });
    },
    calculateProfit(e) {
      if (this.affiliate) {
        this.profit = Number(this.price) - (Number(this.price) * 15) / 100;
      } else {
        this.profit = Number(this.price) - (Number(this.price) * 10) / 100;
      }
    },
  },
  created() {
    axios.get(this.$siteURL + "/api/categories").then((result) => {
      this.sections = result.data;
      console.log(this.sections);
    });
    axios.get(this.$siteURL + "/js/country/countries.json").then((result) => {
      this.countries = result.data;
      console.log(this.countries);
    });
    Vibrant.from();
  },
};
</script>
