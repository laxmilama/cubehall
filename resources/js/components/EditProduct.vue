<template>
  <div>
    <div>
      <div class="mt-m mt-s">
        <h1>Product Edit</h1>
      </div>
      <div>
        <div>
          <div>
            <label for="_pdName">Product Name</label>
            <div>
              <textarea type="text" id="_pdName" v-model="name" />
            </div>
          </div>
          <div>
            <label for="_pddescriptioon">Description</label>
            <div>
              <textarea id="_pddescriptioon" v-model="description" />
            </div>
          </div>
          <div>
            <label for="_pdinventory">
              <h4>Inventory</h4>
            </label>
            <div>
              <div v-for="(meta, i) in metas" :key="i">
                <div class="flex-box">
                  <div>
                    <img
                      :src="`${$siteURL}/images/product/thumb/${meta.thumbnail}`"
                      alt=""
                    />
                  </div>
                  <div>
                    <label for="_pmeta_title">Title</label>
                    <div>
                      <input type="text" v-model="metas[i].title" ic="_pmeta_title" />
                    </div>
                  </div>
                  <div>
                    <label for="_pmeta_stock">Stocks</label>
                    <div>
                      <input type="text" v-model="metas[i].stock" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <label for="_pdsection">
              <h4>Section</h4>
              <span
                >Add your video to one section. Sections can help viewers discover your
                content faster.</span
              >
            </label>
            <div>
              <select name="" id="">
                <option value="0">None</option>
                <option v-for="section in sections" :key="section.id" :value="section.id">
                  {{ section.name }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "productEdit",
  data() {
    return {
      name: this.product.name,
      description: this.product.description,
      metas: this.product.metas,
      sections: [],
    };
  },
  props: {
    product: Object,
    studioid: Number,
  },
  methods: {
    createSection() {
      return true;
    },
  },
  async mounted() {
    console.log(this.studio);
    await axios
      .get(this.$siteURL + "/api/studio/sections?studio=" + this.studioid)
      .then((res) => {
        res.data.forEach((e) => {
          this.sections.push(e);
        });
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
