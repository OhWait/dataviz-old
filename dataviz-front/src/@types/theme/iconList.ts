import { i18n } from '@/plugins/i18n';

const { t } = i18n.global;

export interface IThemeIcon {
  icon: string;
  slug: string;
  title: string;
  active: boolean;
}

export const themeIconList: IThemeIcon[] = [
  {
    icon: 'mdi-account-group',
    slug: 'population',
    title: t('theme.population'),
    active: true,
  },
  {
    icon: 'mdi-home-city',
    slug: 'habitat',
    title: t('theme.habitat'),
    active: false,
  },
  {
    icon: 'mdi-train-car',
    slug: 'mobilite',
    title: t('theme.mobilite'),
    active: true,
  },
  {
    icon: 'mdi-briefcase',
    slug: 'emploi',
    title: t('theme.emploi'),
    active: false,
  },
  {
    icon: 'mdi-currency-eur',
    slug: 'economie',
    title: t('theme.economie'),
    active: false,
  },
  {
    icon: 'mdi-school',
    slug: 'education',
    title: t('theme.education'),
    active: false,
  },
  {
    icon: 'mdi-grass',
    slug: 'foncier',
    title: t('theme.foncier'),
    active: false,
  },
];
