import { mount } from '@vue/test-utils';
import { createRouter, createWebHistory } from 'vue-router';
import { nextTick } from 'vue';
import 'vuetify/styles';
import App from '@/App.vue';

const HomeComponent = { template: '<div>Home</div>' };
const AboutComponent = { template: '<div>About</div>' };

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: HomeComponent },
    { path: '/about', component: AboutComponent },
  ],
});

vi.mock('@/components/NavBar.vue', async importOriginal => {
  const original = await importOriginal();
  return {
    ...original,
    default: {
      name: 'NavBar',
      template: '<div></div>',
    },
  };
});

describe('App.vue', () => {
  it('renders the correct component via router-view', async () => {
    const wrapper = mount(App, {
      global: {
        plugins: [router],
      },
    });

    await router.isReady();

    expect(wrapper.html()).toContain('<div>Home</div>');

    await router.push('/about');
    await nextTick();

    expect(wrapper.html()).toContain('<div>About</div>');
  });
});
