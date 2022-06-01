<template>
  <div>
    <a-menu
        :default-selected-keys="['1']"
        :default-open-keys="['2']"
        mode="inline"
        :theme="theme"
        :inline-collapsed="collapsed"
    >
      <template v-for="item in menus">
        <a-menu-item v-if="!item.children||item.children.length<1" :key="item.path" @click="navigator(item)">
          <a-icon :type="item.icon"/>
          <span>{{ item.meta.title }}</span>
        </a-menu-item>
        <sub-menu v-else :key="item.path" :menu-info="item"/>
      </template>
    </a-menu>
  </div>
</template>

<script>

import {Menu} from 'ant-design-vue';

const SubMenu = {
  template: `
    <a-sub-menu :key="menuInfo.path" v-bind="$props" v-on="$listeners">
    <span slot="title">
          <a-icon :type="menuInfo.icon"/><span>{{ menuInfo.meta.title }}</span>
        </span>
    <template v-for="item in menuInfo.children">
      <a-menu-item v-if="!item.children||item.children.length<1" :key="item.key" @click="navigator(item)">
        <a-icon :type="item.icon"/>
        <span>{{ item.meta.title }}</span>
      </a-menu-item>
      <sub-menu v-else :key="item.path" :menu-info="item"/>
    </template>
    </a-sub-menu>
  `,
  name: 'SubMenu',
  // must add isSubMenu: true
  isSubMenu: true,
  props: {
    ...Menu.SubMenu.props,
    // Cannot overlap with properties within Menu.SubMenu.props
    menuInfo: {
      type: Object,
      default: () => ({}),
    },
  },
  methods: {
    navigator(route) {
      //如果路由与当前路由相同则什么也不做
      if (route.path === this.$route.path) {
        return;
      }
      this.$router.push({path: route.path})
    }
  }

};
export default {
  components: {
    'sub-menu': SubMenu,
  },
  props: {
    menus: {
      type: Array,
      default: () => [],
    }
  },
  data() {
    return {
      collapsed: false,
      theme: this.$store.state.theme
    };
  },
  watch: {
    '$store.state.theme'(n) {
      this.theme = n
    }
    //立即更新
  },
  methods: {
    toggleCollapsed() {
      this.collapsed = !this.collapsed;
    },
    navigator(route) {
      //如果路由与当前路由相同则什么也不做
      if (route.path === this.$route.path) {
        return;
      }
      this.$router.push({path: route.path})
    }
  },
};
</script>
