<template>
  <a-select show-search :value="value" placeholder="請輸入關鍵字" :style="`width:${width}`"
            :default-active-first-option="false" :show-arrow="false" :filter-option="false" :not-found-content="null"
            @search="handleSearch" @change="handleChange" :disabled="disable">
    <a-select-option v-for="(d, index) in formData" :key="index">
      {{ d.name }}
    </a-select-option>
  </a-select>
</template>
<script>

import debounce from 'lodash/debounce';

export default {
  props: {
    value: {
      type: String,
      default: ''
    },
    searchForm: {
      type: Object,
      default() {
        return {};
      }
    },
    width: {
      type: String,
      default: '172px'
    },
    url: {
      type: String,
      default: 'admin/park/search'
    },
    disable: {
      type: Boolean,
      default() {
        return false;
      }
    }
  },
  data() {
    this.handleSearch = debounce(this.handleSearch, 500);
    return {
      formData: [],
    };
  },
  methods: {
    async handleSearch(value) {
      if (value == null || value == undefined || value == '') {
        return;
      }
      this.formData = await this.axios.post(this.url, {keywords: value})
    },
    handleChange(value) {
      this.$emit('changeValue', {value: this.formData[value], form: this.searchForm});
    },
  },
};
</script>
