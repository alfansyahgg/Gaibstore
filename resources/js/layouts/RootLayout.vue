<template lang="">
    <n-config-provider
        :locale="locale"
        :date-locale="dateLocale"
        :theme-overrides="themeOverrides"
        preflight-style-disabled
        class="!font-montserrat"
    >
        <n-message-provider>
            <n-loading-bar-provider>
                <ProviderLayout>
                    <slot />
                </ProviderLayout>
            </n-loading-bar-provider>
        </n-message-provider>
    </n-config-provider>
</template>
<script setup>
import resolveConfig from "tailwindcss/resolveConfig.js";
import tailwindConfig from "tailwindConfig";

import { enUS, dateIdID } from "naive-ui";
const locale = ref(enUS);
const dateLocale = ref(dateIdID);
const { theme } = resolveConfig(tailwindConfig);

const themeOverrides = {
    common: {
        fontFamily: theme.fontFamily.sans,
        fontFamilyMono: theme.fontFamily.mono,
        fontWeight: theme.fontWeight.normal,
        fontWeightStrong: theme.fontWeight.medium,
        cubicBezierEaseInOut: theme.transitionTimingFunction["in-out"],
        cubicBezierEaseOut: theme.transitionTimingFunction.out,
        cubicBezierEaseIn: theme.transitionTimingFunction.in,
        borderRadius: theme.borderRadius.DEFAULT,
        borderRadiusSmall: theme.borderRadius.sm,
        fontSize: theme.fontSize.base[0],
        fontSizeMini: theme.fontSize.xs[0],
        fontSizeTiny: theme.fontSize.xs[0],
        fontSizeSmall: theme.fontSize.sm[0],
        fontSizeMedium: theme.fontSize.base[0],
        fontSizeLarge: theme.fontSize.lg[0],
        fontSizeHuge: theme.fontSize.xl[0],
        lineHeight: theme.lineHeight.normal,
        heightMini: theme.height[4],
        heightTiny: theme.height[6],
        heightSmall: theme.height[7],
        heightMedium: theme.height[8],
        heightLarge: theme.height[10],
        heightHuge: theme.height[11],
        baseColor: theme.colors.white,
        primaryColor: theme.colors.primary[500],
        primaryColorHover: theme.colors.primary[400],
        primaryColorPressed: theme.colors.primary[600],
        primaryColorSuppl: theme.colors.primary[400],
        textColorBase: theme.colors.slate[500],
        dividerColor: theme.borderColor.DEFAULT,
        borderColor: theme.borderColor.DEFAULT,
        invertedColor: theme.colors.slate[800],
        boxShadow1: theme.boxShadow.DEFAULT,
        boxShadow2: theme.boxShadow.md,
        boxShadow3: theme.boxShadow.lg,
        successColor: theme.colors.primary[500],
        successColorHover: theme.colors.primary[400],
        successColorPressed: theme.colors.primary[600],
        successColorSuppl: theme.colors.primary[400],
    },
    LoadingBar: {
        colorLoading: theme.colors?.primary[300],
        colorError: "rgba(255, 0, 0, 1)",
    },
};
</script>
<style lang=""></style>