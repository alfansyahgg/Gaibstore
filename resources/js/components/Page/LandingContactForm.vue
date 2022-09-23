<template>
    <div class="contact-form py-24 p-8">
        <page-section-title>
            <template #title>Send Your Message</template>
            <template #desc>
                Excepteur sint occaecat cupidatat non proident, sunt in culpa
                qui officia deserunt mollit anim id est laborum.</template
            >
        </page-section-title>
        <n-form>
            <n-grid :x-gap="10" :y-gap="14" cols="1 400:2">
                <n-grid-item>
                    <n-form-item label="Name">
                        <n-input></n-input>
                    </n-form-item>
                </n-grid-item>
                <n-grid-item>
                    <n-form-item label="Email">
                        <n-input></n-input>
                    </n-form-item>
                </n-grid-item>
            </n-grid>
            <n-form-item label="Subject">
                <n-input></n-input>
            </n-form-item>
            <n-form-item label="Message">
                <n-input type="textarea"></n-input>
            </n-form-item>
            <n-space justify="end">
                <n-button type="primary" size="large">Send</n-button>
            </n-space>
        </n-form>
    </div>
</template>