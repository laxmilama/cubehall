<template>
  <div class="flex-box">
    <div class="sct1_hf">
      <div v-if="step == 1" class="">
        <div>
          <div>
            <h1>Identity Verification</h1>
            <p>
              Our focus on safety and security means that we verify the information of all
              our users. This helps to make sure you’re you, so you can trust those you do
              business with through CubeHall and protect you from fraud.
            </p>
          </div>
          <div class="mt-s">
            <select v-model="country" class="inp_height">
              <option disabled value="">Please select one</option>
              <option v-for="c in countries" :key="c.code" :value="c.code">
                {{ c.name }}
              </option>
            </select>
          </div>
          <div>
            <div>
              <h2>Use a valid government-issued document.</h2>
              <span
                >Only the following documents listed below will be accepted, all other
                documents will be rejected.</span
              >
            </div>
            <div v-for="(o, key) in options" :key="key" class="_kyc_opt_wrap">
              <label :for="`gov_id_${key}`">
                <div class="_kyc_opt_radio">
                  <span>{{ o }}</span>
                  <input
                    class="_kyc_radio"
                    name="gov_id_type_option"
                    :value="`${key}`"
                    type="radio"
                    :id="`gov_id_${key}`"
                    v-model="option"
                  />
                </div>
              </label>
            </div>
          </div>
        </div>
        <div class="add-btn-wrap">
          <button
            @click.prevent="next()"
            v-bind:disabled="!disableButton"
            class="btn-normalize btn-third"
            v-bind:class="{ disabled: !disableButton }"
          >
            Continue
          </button>
        </div>
      </div>

      <div v-if="step == 2" class="">
        <div>
          <div v-if="option == 'passport'">
            <h2>Upload an image of your passport</h2>
            <div>
              <p>
                Make sure the photo of your passport isn’t blurry and that it clearly
                shows your face.
              </p>
              <div class="_kyc_id_card">
                <div class="_kyc_id_updr_full">
                  <div class="_kyc_ico_wrap">
                    <input
                      class="_kyc_input"
                      type="file"
                      accept="image/jpeg"
                      name=""
                      id="id-front-img"
                      @change="uploadFront"
                    />
                    <label class="_kyc_lbl" for="id-front-img">
                      <div class="_kyc_box_wrap">
                        <div class="_kyc_icon_box">
                          <div class="">
                            <div>
                              <svg
                                version="1.1"
                                id="Layer_1"
                                width="50"
                                height="50"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512 512"
                                xml:space="preserve"
                              >
                                <path
                                  d="M458.667,341.333h-85.333c-5.888,0-10.667,4.779-10.667,10.667c0,5.888,4.779,10.667,10.667,10.667h85.333
				c5.888,0,10.667-4.779,10.667-10.667C469.333,346.112,464.555,341.333,458.667,341.333z"
                                />
                                <path
                                  d="M309.333,234.667h64c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667h-64
				c-5.888,0-10.667,4.779-10.667,10.667S303.445,234.667,309.333,234.667z"
                                />
                                <path
                                  d="M416,234.667h42.667c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H416
				c-5.888,0-10.667,4.779-10.667,10.667S410.112,234.667,416,234.667z"
                                />
                                <path
                                  d="M309.333,298.667h149.333c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H309.333
				c-5.888,0-10.667,4.779-10.667,10.667S303.445,298.667,309.333,298.667z"
                                />
                                <path
                                  d="M309.333,362.667h21.333c5.888,0,10.667-4.779,10.667-10.667c0-5.888-4.779-10.667-10.667-10.667h-21.333
				c-5.888,0-10.667,4.779-10.667,10.667C298.667,357.888,303.445,362.667,309.333,362.667z"
                                />
                                <path
                                  d="M458.667,64H53.333C23.936,64,0,87.936,0,117.333v277.333C0,424.064,23.936,448,53.333,448h405.333
				C488.064,448,512,424.064,512,394.667V117.333C512,87.936,488.064,64,458.667,64z M490.667,394.667c0,17.643-14.357,32-32,32
				H53.333c-17.643,0-32-14.357-32-32V149.333h469.333V394.667z M490.667,128H21.333v-10.667c0-17.643,14.357-32,32-32h405.333
				c17.643,0,32,14.357,32,32V128z"
                                />
                                <path
                                  d="m158,320.6c-52.1,0-93.8,42.7-93.8,93.8h20.8c0-40.7 32.3-73 73-73s73,32.3 73,73h20.9c-0.1-51-41.8-93.8-93.9-93.8z"
                                />
                                <path
                                  d="m159,307.1c25,0 45.9-20.9 46.9-46.9 0-26.1-20.9-46.9-46.9-46.9s-46.9,20.9-46.9,46.9c0,26 20.9,46.9 46.9,46.9zm0-73c14.6,0 26.1,11.5 26.1,26.1s-11.5,26.1-26.1,26.1c-14.6,0-26.1-11.5-26.1-26.1s11.5-26.1 26.1-26.1z"
                                />
                              </svg>
                            </div>
                            <div>
                              <span>
                                <div>Upload passport</div>
                                <div>JPEG or PNG only</div>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </label>

                    <div v-if="front" class="_kyc_preview">
                      <img
                        class="_kyc_preview_img"
                        :src="`${$siteURL}/images/kyc/small/` + front"
                        alt=""
                      />
                      <div class="_KYC_close_relative" @click="remove('front')">
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
                          class="feather feather-x"
                        >
                          <line x1="18" y1="6" x2="6" y2="18"></line>
                          <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="option == 'idcard'">
            <h2>Upload images of your identity card</h2>
            <div>
              <p>
                Make sure the photo of your itentity card isn’t blurry and that it clearly
                shows your face.
              </p>
              <div class="_kyc_id_card">
                <div class="_kyc_id_updr">
                  <div class="_kyc_ico_wrap">
                    <input
                      class="_kyc_input"
                      type="file"
                      accept="image/jpeg"
                      name=""
                      id="id-front-img"
                      @change="uploadFront"
                    />
                    <label class="_kyc_lbl" for="id-front-img">
                      <div class="_kyc_box_wrap">
                        <div class="_kyc_icon_box">
                          <div class="">
                            <div>
                              <svg
                                version="1.1"
                                id="Layer_1"
                                width="50"
                                height="50"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512 512"
                                xml:space="preserve"
                              >
                                <path
                                  d="M458.667,341.333h-85.333c-5.888,0-10.667,4.779-10.667,10.667c0,5.888,4.779,10.667,10.667,10.667h85.333
				c5.888,0,10.667-4.779,10.667-10.667C469.333,346.112,464.555,341.333,458.667,341.333z"
                                />
                                <path
                                  d="M309.333,234.667h64c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667h-64
				c-5.888,0-10.667,4.779-10.667,10.667S303.445,234.667,309.333,234.667z"
                                />
                                <path
                                  d="M416,234.667h42.667c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H416
				c-5.888,0-10.667,4.779-10.667,10.667S410.112,234.667,416,234.667z"
                                />
                                <path
                                  d="M309.333,298.667h149.333c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H309.333
				c-5.888,0-10.667,4.779-10.667,10.667S303.445,298.667,309.333,298.667z"
                                />
                                <path
                                  d="M309.333,362.667h21.333c5.888,0,10.667-4.779,10.667-10.667c0-5.888-4.779-10.667-10.667-10.667h-21.333
				c-5.888,0-10.667,4.779-10.667,10.667C298.667,357.888,303.445,362.667,309.333,362.667z"
                                />
                                <path
                                  d="M458.667,64H53.333C23.936,64,0,87.936,0,117.333v277.333C0,424.064,23.936,448,53.333,448h405.333
				C488.064,448,512,424.064,512,394.667V117.333C512,87.936,488.064,64,458.667,64z M490.667,394.667c0,17.643-14.357,32-32,32
				H53.333c-17.643,0-32-14.357-32-32V149.333h469.333V394.667z M490.667,128H21.333v-10.667c0-17.643,14.357-32,32-32h405.333
				c17.643,0,32,14.357,32,32V128z"
                                />
                                <path
                                  d="m158,320.6c-52.1,0-93.8,42.7-93.8,93.8h20.8c0-40.7 32.3-73 73-73s73,32.3 73,73h20.9c-0.1-51-41.8-93.8-93.9-93.8z"
                                />
                                <path
                                  d="m159,307.1c25,0 45.9-20.9 46.9-46.9 0-26.1-20.9-46.9-46.9-46.9s-46.9,20.9-46.9,46.9c0,26 20.9,46.9 46.9,46.9zm0-73c14.6,0 26.1,11.5 26.1,26.1s-11.5,26.1-26.1,26.1c-14.6,0-26.1-11.5-26.1-26.1s11.5-26.1 26.1-26.1z"
                                />
                              </svg>
                            </div>
                            <div>
                              <span>
                                <div>Upload front</div>
                                <div>JPEG or PNG only</div>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </label>
                    <div v-if="front" class="_kyc_preview">
                      <img
                        class="_kyc_preview_img"
                        :src="`${$siteURL}/images/kyc/small/` + front"
                        alt=""
                      />
                      <div class="_KYC_close_relative" @click="remove('front')">
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
                          class="feather feather-x"
                        >
                          <line x1="18" y1="6" x2="6" y2="18"></line>
                          <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="_kyc_id_updr">
                  <div class="_kyc_ico_wrap">
                    <input
                      class="_kyc_input"
                      type="file"
                      accept="image/jpeg"
                      name=""
                      id="id-back-img"
                      @change="uploadBack"
                    />
                    <label class="_kyc_lbl" for="id-back-img">
                      <div class="_kyc_box_wrap">
                        <div class="_kyc_icon_box">
                          <div class="">
                            <div>
                              <svg
                                version="1.1"
                                id="Layer_1"
                                width="50"
                                height="50"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512 512"
                                xml:space="preserve"
                              >
                                <path
                                  d="M466.373,69.818H47.564C21.873,69.818,0,90.053,0,115.689v279.374c0,25.635,21.873,47.119,47.564,47.119h418.809
			c25.691,0,45.627-21.484,45.627-47.119V115.689C512,90.053,492.064,69.818,466.373,69.818z M493.382,395.062
			c0,15.372-11.582,28.501-27.009,28.501H47.564c-15.427,0-28.945-13.13-28.945-28.501V115.689
			c0-15.373,13.518-27.252,28.945-27.252h418.809c15.427,0,27.009,11.88,27.009,27.252V395.062z"
                                />
                                <path
                                  d="M243,302.545H66.127c-5.146,0-9.309,4.168-9.309,9.309s4.163,9.309,9.309,9.309H243c5.145,0,9.309-4.168,9.309-9.309
			S248.145,302.545,243,302.545z"
                                />
                                <path
                                  d="M243,349.091H66.127c-5.146,0-9.309,4.168-9.309,9.309c0,5.141,4.163,9.309,9.309,9.309H243
			c5.145,0,9.309-4.168,9.309-9.309C252.309,353.259,248.145,349.091,243,349.091z"
                                />
                              </svg>
                            </div>
                            <div>
                              <span>
                                <div>Upload backs</div>
                                <div>JPEG or PNG only</div>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </label>
                    <div v-if="back" class="_kyc_preview">
                      <img
                        class="_kyc_preview_img"
                        :src="`${$siteURL}/images/kyc/small/` + back"
                        alt=""
                      />
                      <div class="_KYC_close_relative" @click="remove('back')">
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
                          class="feather feather-x"
                        >
                          <line x1="18" y1="6" x2="6" y2="18"></line>
                          <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="option == 'driverslicence'">
            <h2>Upload images of your driver’s license</h2>
            <div>
              <p>
                Make sure your photos aren’t blurry and the front of your driver’s license
                clearly shows your face.
              </p>
              <div class="_kyc_id_card">
                <div class="_kyc_id_updr">
                  <div class="_kyc_ico_wrap">
                    <input
                      class="_kyc_input"
                      type="file"
                      accept="image/jpeg"
                      name=""
                      id="id-front-img"
                      @change="uploadFront"
                    />
                    <label class="_kyc_lbl" for="id-front-img">
                      <div class="_kyc_box_wrap">
                        <div class="_kyc_icon_box">
                          <div class="">
                            <div>
                              <svg
                                version="1.1"
                                id="Layer_1"
                                width="50"
                                height="50"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512 512"
                                xml:space="preserve"
                              >
                                <path
                                  d="M458.667,341.333h-85.333c-5.888,0-10.667,4.779-10.667,10.667c0,5.888,4.779,10.667,10.667,10.667h85.333
				c5.888,0,10.667-4.779,10.667-10.667C469.333,346.112,464.555,341.333,458.667,341.333z"
                                />
                                <path
                                  d="M309.333,234.667h64c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667h-64
				c-5.888,0-10.667,4.779-10.667,10.667S303.445,234.667,309.333,234.667z"
                                />
                                <path
                                  d="M416,234.667h42.667c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H416
				c-5.888,0-10.667,4.779-10.667,10.667S410.112,234.667,416,234.667z"
                                />
                                <path
                                  d="M309.333,298.667h149.333c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H309.333
				c-5.888,0-10.667,4.779-10.667,10.667S303.445,298.667,309.333,298.667z"
                                />
                                <path
                                  d="M309.333,362.667h21.333c5.888,0,10.667-4.779,10.667-10.667c0-5.888-4.779-10.667-10.667-10.667h-21.333
				c-5.888,0-10.667,4.779-10.667,10.667C298.667,357.888,303.445,362.667,309.333,362.667z"
                                />
                                <path
                                  d="M458.667,64H53.333C23.936,64,0,87.936,0,117.333v277.333C0,424.064,23.936,448,53.333,448h405.333
				C488.064,448,512,424.064,512,394.667V117.333C512,87.936,488.064,64,458.667,64z M490.667,394.667c0,17.643-14.357,32-32,32
				H53.333c-17.643,0-32-14.357-32-32V149.333h469.333V394.667z M490.667,128H21.333v-10.667c0-17.643,14.357-32,32-32h405.333
				c17.643,0,32,14.357,32,32V128z"
                                />
                                <path
                                  d="m158,320.6c-52.1,0-93.8,42.7-93.8,93.8h20.8c0-40.7 32.3-73 73-73s73,32.3 73,73h20.9c-0.1-51-41.8-93.8-93.9-93.8z"
                                />
                                <path
                                  d="m159,307.1c25,0 45.9-20.9 46.9-46.9 0-26.1-20.9-46.9-46.9-46.9s-46.9,20.9-46.9,46.9c0,26 20.9,46.9 46.9,46.9zm0-73c14.6,0 26.1,11.5 26.1,26.1s-11.5,26.1-26.1,26.1c-14.6,0-26.1-11.5-26.1-26.1s11.5-26.1 26.1-26.1z"
                                />
                              </svg>
                            </div>
                            <div>
                              <span>
                                <div>Upload front</div>
                                <div>JPEG or PNG only</div>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </label>
                    <div v-if="front" class="_kyc_preview">
                      <img
                        class="_kyc_preview_img"
                        :src="`${$siteURL}/images/kyc/small/` + front"
                        alt=""
                      />
                      <div class="_KYC_close_relative" @click="remove('front')">
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
                          class="feather feather-x"
                        >
                          <line x1="18" y1="6" x2="6" y2="18"></line>
                          <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="_kyc_id_updr">
                  <div class="_kyc_ico_wrap">
                    <input
                      class="_kyc_input"
                      type="file"
                      accept="image/jpeg"
                      name=""
                      id="id-back-img"
                      @change="uploadBack"
                    />
                    <label class="_kyc_lbl" for="id-back-img">
                      <div class="_kyc_box_wrap">
                        <div class="_kyc_icon_box">
                          <div class="">
                            <div>
                              <svg
                                version="1.1"
                                id="Layer_1"
                                width="50"
                                height="50"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512 512"
                                xml:space="preserve"
                              >
                                <path
                                  d="M466.373,69.818H47.564C21.873,69.818,0,90.053,0,115.689v279.374c0,25.635,21.873,47.119,47.564,47.119h418.809
			c25.691,0,45.627-21.484,45.627-47.119V115.689C512,90.053,492.064,69.818,466.373,69.818z M493.382,395.062
			c0,15.372-11.582,28.501-27.009,28.501H47.564c-15.427,0-28.945-13.13-28.945-28.501V115.689
			c0-15.373,13.518-27.252,28.945-27.252h418.809c15.427,0,27.009,11.88,27.009,27.252V395.062z"
                                />
                                <path
                                  d="M243,302.545H66.127c-5.146,0-9.309,4.168-9.309,9.309s4.163,9.309,9.309,9.309H243c5.145,0,9.309-4.168,9.309-9.309
			S248.145,302.545,243,302.545z"
                                />
                                <path
                                  d="M243,349.091H66.127c-5.146,0-9.309,4.168-9.309,9.309c0,5.141,4.163,9.309,9.309,9.309H243
			c5.145,0,9.309-4.168,9.309-9.309C252.309,353.259,248.145,349.091,243,349.091z"
                                />
                              </svg>
                            </div>
                            <div>
                              <span>
                                <div>Upload back</div>
                                <div>JPEG or PNG only</div>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </label>
                    <div v-if="back" class="_kyc_preview">
                      <img
                        class="_kyc_preview_img"
                        :src="`${$siteURL}/images/kyc/small/` + back"
                        alt=""
                      />
                      <div class="_KYC_close_relative" @click="remove('back')">
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
                          class="feather feather-x"
                        >
                          <line x1="18" y1="6" x2="6" y2="18"></line>
                          <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="flex-box">
            <div>
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
                class="feather feather-lock"
              >
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
            </div>

            <div class="_kyc_hint">
              We take steps to help ensure this info stays private. Learn more in our
              Privacy Policy.
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
          <button
            @click.prevent="next()"
            v-bind:disabled="!validateIDForm"
            class="btn-normalize btn-third"
            v-bind:class="{ disabled: !validateIDForm }"
          >
            Next
          </button>
        </div>
      </div>
      <div v-if="step == 3" class="">
        <div>
          <div>
            <h2>Upload photo of yourself.</h2>
            <div>
              <span>We’ll match this photo with the one on your ID.</span>
            </div>
            <div class="_kyc_id_card">
              <div class="_kyc_id_updr_full">
                <div class="_kyc_ico_wrap">
                  <input
                    class="_kyc_input"
                    type="file"
                    accept="image/jpeg"
                    name=""
                    id="id-front-img"
                    @change="uploadProfile"
                  />
                  <label class="_kyc_lbl" for="id-front-img">
                    <div class="_kyc_box_wrap">
                      <div class="_kyc_icon_box">
                        <div class="">
                          <div>
                            <svg
                              version="1.1"
                              id="Layer_1"
                              width="50"
                              height="50"
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              x="0px"
                              y="0px"
                              viewBox="0 0 512 512"
                              xml:space="preserve"
                            >
                              <path
                                d="M256,65.362c-51.057,0-92.596,41.538-92.596,92.596s41.538,92.596,92.596,92.596s92.596-41.538,92.596-92.596
                                        S307.057,65.362,256,65.362z M256,234.213c-42.047,0-76.255-34.208-76.255-76.255S213.953,81.702,256,81.702
                                        s76.255,34.208,76.255,76.255S298.047,234.213,256,234.213z"
                              />
                              <path
                                d="M275.22,163.772c-4.218-1.587-8.936,0.545-10.525,4.768c-1.26,3.351-4.755,5.603-8.693,5.603
                                        c-3.939,0-7.433-2.251-8.693-5.602c-1.589-4.223-6.3-6.355-10.524-4.769c-4.223,1.589-6.359,6.301-4.769,10.524
                                        c3.642,9.681,13.281,16.186,23.986,16.186c10.703,0,20.343-6.505,23.988-16.185C281.577,170.074,279.442,165.363,275.22,163.772z"
                              />
                              <path
                                d="M407.388,387.634c-7.663-33.762-26.794-64.409-53.869-86.295c-27.482-22.212-62.114-34.446-97.519-34.446
                                        s-70.036,12.234-97.519,34.448c-27.076,21.886-46.207,52.534-53.869,86.296c-0.998,4.401,1.759,8.777,6.16,9.776
                                        c0.609,0.137,1.217,0.205,1.816,0.205c3.731,0,7.1-2.572,7.961-6.364c14.431-63.601,70.131-108.02,135.45-108.02
                                        c65.318,0,121.018,44.418,135.451,108.018c0.999,4.4,5.376,7.149,9.777,6.159C405.628,396.412,408.385,392.035,407.388,387.634z"
                              />
                              <path
                                d="M443.915,0H68.085c-4.513,0-8.17,3.657-8.17,8.17v413.957c0,4.513,3.657,8.17,8.17,8.17h375.83
                                        c4.513,0,8.17-3.657,8.17-8.17V8.17C452.085,3.657,448.428,0,443.915,0z M435.745,413.957H76.255V16.34h359.489V413.957z"
                              />
                            </svg>
                          </div>
                          <div>
                            <span>
                              <div>Upload profile</div>
                              <div>JPEG or PNG only</div>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </label>

                  <div v-if="profile" class="_kyc_preview">
                    <img
                      class="_kyc_preview_img"
                      :src="`${$siteURL}/images/kyc/small/` + profile"
                      alt=""
                    />
                    <div class="_KYC_close_relative" @click="remove('profile')">
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
                        class="feather feather-x"
                      >
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                      </svg>
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
          <button
            @click.prevent="save"
            v-bind:disabled="!validateProfile"
            class="btn-normalize btn-third"
            v-bind:class="{ disabled: !validateProfile }"
          >
            Submit to Review
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      options: {
        passport: "Passport",
        idcard: "Identity Card",
        driverslicence: "Driver's licence",
      },
      countries: [],
      step: 1,
      country: "",
      option: null,
      front: null,
      back: null,
      profile: null,
    };
  },
  created() {
    axios.get(this.$siteURL + "/js/country/countries.json").then((result) => {
      this.countries = result.data;
      console.log(this.countries);
    });
  },
  methods: {
    prev() {
      this.step--;
    },
    next() {
      this.step++;
    },
    async uploadFront(e) {
      let idData = new FormData();
      idData.append("image", e.target.files[0]);
      await axios
        .post(this.$siteURL + "/account/uploader/image", idData, {
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
          this.front = res.data.image;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    uploadBack(e) {
      let idData = new FormData();
      idData.append("image", e.target.files[0]);
      axios
        .post(this.$siteURL + "/account/uploader/image", idData, {
          onUploadProgress: (progressEvent) => {
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
            );
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%sssss"
            );
          },
        })
        .then((res) => {
          console.log("FUCK back");
          this.back = res.data.image;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async uploadProfile(e) {
      let idData = new FormData();
      idData.append("image", e.target.files[0]);
      await axios
        .post(this.$siteURL + "/account/uploader/image", idData, {
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
          this.profile = res.data.image;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async save() {
      let kycData = new FormData();
      kycData.append("country", this.country);
      kycData.append("front", this.front);
      kycData.append("back", this.back);
      kycData.append("type", this.option);
      kycData.append("profile", this.profile);

      axios
        .post(this.$siteURL + "/account/post/kyc", kycData)
        .then((res) => {
          window.history.back();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    remove(p) {
      if (p == "front") {
        this.front = null;
      } else if (p == "back") {
        this.back = null;
      } else if (p == "profile") {
        this.profile = null;
      }
    },
  },
  computed: {
    disableButton: function () {
      if (this.country != null && this.option != null && this.country != "") {
        return true;
      }
      return false;
    },
    validateIDForm: function () {
      if (this.option == "passport") {
        if (this.front != null) {
          return true;
        }
      } else if (this.option == "idcard" || this.option == "driverslicence") {
        if (this.front != null && this.back != null) {
          return true;
        }
      }
      return false;
    },
    validateProfile: function () {
      if (this.profile != null) {
        return true;
      }
    },
  },
};
</script>
<style>
.sct1_hf {
  margin-top: 32px !important;
  margin-bottom: 32px !important;
  max-width: 480px !important;
}
._kyc_id_card {
  height: 200px !important;
  -webkit-box-pack: justify !important;
  -webkit-box-align: start !important;
  margin-top: 24px !important;
  margin-bottom: 48px !important;
  display: flex !important;
  align-items: flex-start !important;
  justify-content: space-between !important;
}
._kyc_id_updr {
  width: 49% !important;
  height: 75% !important;
}
._kyc_id_updr_full {
  width: 100% !important;
  height: 100% !important;
}
._kyc_ico_wrap {
  position: relative !important;
  cursor: pointer !important;
  height: 100% !important;
}
._kyc_input {
  position: absolute !important;
  width: 100% !important;
  height: 100% !important;
  outline: none !important;
  font-size: 1px !important;
  text-align: center !important;
  opacity: 0 !important;
}
._kyc_icon_box {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}
._kyc_box_wrap {
  height: 100%;
}
._kyc_lbl {
  position: absolute !important;
  width: 100% !important;
  height: 100% !important;
  cursor: pointer !important;
  border-style: dashed !important;
  border-radius: 6px !important;
  background-color: rgb(255, 255, 255) !important;
  background-repeat: no-repeat !important;
  background-size: contain !important;
  background-position: center center !important;
  text-align: center !important;
  border-color: rgb(113, 113, 113) !important;
  border-width: 1px !important;
}
.disabled {
  background: var(--gray-medium) !important;
}
._kyc_opt_wrap {
  outline: 0px !important;
  cursor: pointer !important;
  padding: 24px 0px !important;
  border-bottom: 1px solid rgb(221, 221, 221) !important;
  list-style: none !important;
}
._kyc_opt_radio {
  display: flex;
  justify-content: space-between;
  cursor: pointer !important;
}
._kyc_radio {
  appearance: none !important;
  border-width: 1px !important;
  border-style: solid !important;
  border-color: rgb(176, 176, 176) !important;
  background: rgb(255, 255, 255) !important;
  overflow: hidden !important;
  border-radius: 50% !important;
  vertical-align: top !important;
  outline: none !important;
  width: 22px;
  height: 22px;
}
._kyc_preview {
  position: absolute;
  height: 100%;
  width: 100%;
}
._kyc_preview_img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}
._kyc_radio:checked {
  background: #111;
  border-width: 7px !important;
  border-style: solid !important;
  border-color: var(--gray-very-dark) !important;
  background: rgb(255, 255, 255) !important;
  overflow: hidden !important;
  border-radius: 50% !important;
  vertical-align: top !important;
  outline: none !important;
  width: 22px;
  height: 22px;
}
._kyc_hint {
  color: var(--gray-dark);
}
._KYC_close_relative {
  position: absolute;
  top: 0;
  right: 0;
  padding: 5px;
  background: #fff;
  border-radius: 50%;
}
.inp_height {
  max-width: 100%;
  height: 47px;
  padding: 10px 25px;
  border-radius: 4px;
  font-size: 16px;
  border: solid 2px var(--gray-medium);
  box-sizing: border-box;
}
</style>
