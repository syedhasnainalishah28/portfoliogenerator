<template>
  <div class="h-screen w-full bg-[#f0f2f5] text-[#1e1b20] overflow-hidden flex flex-col">
    <!-- Header -->
    <header class="bg-white border-b border-[#e5e7eb] z-10 shrink-0 shadow-sm">
      <div class="flex items-center justify-between px-4 sm:px-6 py-2.5">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#f28b11] to-[#f2b311] flex flex-col items-center justify-center text-white font-bold text-sm shadow-md">H</div>
            <div>
                <p class="text-sm sm:text-lg font-extrabold tracking-tight leading-none">HA Tech Generator</p>
                <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#f28b11] mt-0.5">Live Builder</p>
            </div>
        </div>
        
        <!-- Center Template Switcher -->
        <div class="hidden lg:flex items-center bg-gray-100 rounded-full p-1 border border-gray-200 shadow-inner">
            <button v-for="template in templateOptions" :key="template.key" 
                class="px-4 py-1.5 rounded-full text-xs font-bold transition-all"
                :class="form.template_key === template.key ? 'bg-white text-[#f28b11] shadow' : 'text-gray-500 hover:text-gray-700'"
                @click="selectTemplate(template.key)">
                {{ template.name }}
            </button>
        </div>

        <div class="flex items-center gap-3">
            <button class="ha-btn px-4 sm:px-6 py-2 text-xs sm:text-sm shadow-lg font-bold flex items-center gap-2" :disabled="downloading" @click="generateAndDownload">
                <span v-if="downloading" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Building...
                </span>
                <span v-else>Download ZIP <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg></span>
            </button>
        </div>
      </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 flex overflow-hidden">
        
        <!-- Left Sidebar Form -->
        <aside class="w-full lg:w-[35%] xl:w-[400px] h-full bg-white border-r border-gray-200 overflow-y-auto custom-scrollbar flex flex-col shrink-0 relative z-10 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            
            <div class="p-6">
                <!-- Mobile Template Switcher -->
                <div class="lg:hidden mb-6 block">
                    <label class="ha-label">Template Design</label>
                    <select v-model="form.template_key" @change="selectTemplate(form.template_key)" class="ha-input bg-gray-50 font-bold">
                        <option v-for="temp in templateOptions" :value="temp.key" :key="temp.key">{{ temp.name }} ({{temp.style}})</option>
                    </select>
                </div>

                <div v-if="loadingFields" class="py-10 text-center text-gray-400 font-bold animate-pulse">Loading engine fields...</div>
                
                <div v-else class="space-y-8">
                    <!-- Standard Fields -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-6 rounded-full bg-[#f28b11]"></div>
                            <h3 class="text-sm uppercase tracking-widest font-black text-gray-800">Basic Info</h3>
                        </div>
                        
                        <template v-for="field in (templateFieldsLayout.filter(f => ['text', 'email', 'number', 'url', 'color'].includes(f.type)))" :key="field.name">
                            <div>
                                <label class="ha-label text-xs">{{ field.label }}</label>
                                <div v-if="field.type === 'color'" class="flex items-center gap-3">
                                    <input v-model="form.dynamic_fields[field.name]" type="color" class="w-10 h-10 rounded-lg cursor-pointer border-2 border-gray-100 shadow-sm transition-transform hover:scale-110" />
                                    <span class="text-xs font-mono text-gray-500 uppercase px-2 py-1 bg-gray-100 rounded">{{ form.dynamic_fields[field.name] }}</span>
                                </div>
                                <input v-else v-model="form.dynamic_fields[field.name]" :type="field.type" class="ha-input text-sm py-2 px-3 shadow-sm" :placeholder="`e.g. ${field.default || ''}`" />
                            </div>
                        </template>
                        
                        <template v-for="field in textareaFields" :key="field.name">
                            <div>
                                <label class="ha-label text-xs">{{ field.label }}</label>
                                <textarea v-model="form.dynamic_fields[field.name]" class="ha-input text-sm py-2 px-3 min-h-[80px] resize-y shadow-sm" :placeholder="field.default"></textarea>
                            </div>
                        </template>
                    </div>

                    <!-- Complex Lists -->
                    <div class="space-y-8 pt-6 border-t border-gray-100" v-if="listFields.length > 0 || projectFields.length > 0">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-6 rounded-full bg-[#f28b11]"></div>
                            <h3 class="text-sm uppercase tracking-widest font-black text-gray-800">Dynamic Lists</h3>
                        </div>

                        <template v-for="field in listFields" :key="field.name">
                <div v-else class="space-y-10">
                    <template v-for="sectionName in uniqueSections" :key="sectionName">
                        <div class="space-y-5">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-1.5 h-6 rounded-full bg-[#f28b11]"></div>
                                <h3 class="text-sm uppercase tracking-widest font-black text-gray-800">{{ sectionName }}</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <template v-for="field in getFieldsBySection(sectionName)" :key="field.name">
                                    <div :class="{'md:col-span-2': ['textarea', 'list', 'projects', 'image'].includes(field.type)}">
                                        
                                        <!-- Text / Email / URL / Number -->
                                        <template v-if="['text', 'email', 'number', 'url'].includes(field.type)">
                                            <label class="ha-label text-xs">{{ field.label }}</label>
                                            <input v-model="form.dynamic_fields[field.name]" :type="field.type" class="ha-input text-sm py-2 px-3 shadow-sm bg-white" :placeholder="`e.g. ${field.default || ''}`" />
                                        </template>
                                        
                                        <!-- Color -->
                                        <template v-else-if="field.type === 'color'">
                                            <label class="ha-label text-xs">{{ field.label }}</label>
                                            <div class="flex items-center gap-3">
                                                <input v-model="form.dynamic_fields[field.name]" type="color" class="w-10 h-10 rounded-lg cursor-pointer border-2 border-gray-100 shadow-sm transition-transform hover:scale-110" />
                                                <span class="text-xs font-mono text-gray-500 uppercase px-2 py-1 bg-gray-100 rounded">{{ form.dynamic_fields[field.name] }}</span>
                                            </div>
                                        </template>

                                        <!-- Textarea -->
                                        <template v-else-if="field.type === 'textarea'">
                                            <label class="ha-label text-xs">{{ field.label }}</label>
                                            <textarea v-model="form.dynamic_fields[field.name]" class="ha-input text-sm py-2 px-3 min-h-[80px] resize-y shadow-sm bg-white" :placeholder="field.default"></textarea>
                                        </template>

                                        <!-- Image -->
                                        <template v-else-if="field.type === 'image'">
                                            <label class="ha-label text-xs">{{ field.label }}</label>
                                            <div class="p-5 rounded-xl border border-dashed border-gray-300 bg-white flex flex-col items-center justify-center gap-3 shadow-sm">
                                                <div class="text-center">
                                                    <label class="text-[#f28b11] font-semibold text-sm cursor-pointer hover:underline">
                                                        Upload Image
                                                        <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.webp" @change="e => selectDynamicImage(e, field.name)" />
                                                    </label>
                                                    <p class="text-xs text-[#9ca3af] mt-1" v-if="form.dynamic_fields[field.name] === 'uploaded' || form.images[field.name]">Image selected</p>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Simple List -->
                                        <template v-else-if="field.type === 'list'">
                                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 shadow-sm">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h4 class="text-xs font-bold text-gray-700">{{ field.label }}</h4>
                                                    <button class="text-[10px] font-bold text-white bg-gray-800 hover:bg-black px-2 py-1 rounded shadow-sm transition-colors" type="button" @click="addListItem(field.name)">+ ADD ITEM</button>
                                                </div>
                                                <div class="space-y-2">
                                                    <div v-for="(_, i) in form.dynamic_fields[field.name]" :key="`list-${field.name}-${i}`" class="relative group">
                                                        <input v-model="form.dynamic_fields[field.name][i]" class="ha-input text-sm py-1.5 px-3 pr-8 shadow-sm bg-white" placeholder="Value" />
                                                        <button class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-300 hover:text-red-500 transition-colors p-1 bg-white rounded-md" type="button" @click="removeListItem(field.name, i)">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Complex Projects List -->
                                        <template v-else-if="field.type === 'projects'">
                                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 shadow-sm">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h4 class="text-xs font-bold text-gray-700">{{ field.label }}</h4>
                                                    <button class="text-[10px] font-bold text-[#f28b11] bg-orange-100 hover:bg-orange-200 px-2 py-1 rounded shadow-sm transition-colors" type="button" @click="addProject(field.name)">+ ADD PROJECT</button>
                                                </div>
                                                <div class="space-y-4">
                                                    <div v-for="(project, i) in form.dynamic_fields[field.name]" :key="`proj-${field.name}-${i}`" class="rounded-lg bg-white border border-gray-200 p-4 relative shadow-sm transition-shadow hover:shadow-md">
                                                        <button class="absolute -right-2 -top-2 bg-red-100 rounded-full w-6 h-6 flex items-center justify-center text-red-600 hover:bg-red-500 hover:text-white transition-colors shadow-sm" type="button" @click="removeProject(field.name, i)">
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                        <div class="space-y-3">
                                                            <div><input v-model="project.name" class="ha-input text-sm py-1.5 px-3 bg-gray-50 focus:bg-white" placeholder="Project Name" /></div>
                                                            <div><input v-model="project.link" class="ha-input text-sm py-1.5 px-3 bg-gray-50 focus:bg-white" placeholder="External URL" /></div>
                                                            <div><textarea v-model="project.description" class="ha-input text-sm py-1.5 px-3 bg-gray-50 focus:bg-white min-h-[50px]" placeholder="Short description"></textarea></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

                <div v-if="message || errorMessage" class="mt-8 p-3 rounded-lg text-xs font-bold text-center border shadow-sm" :class="errorMessage ? 'bg-red-50 text-red-600 border-red-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100'">
                    {{ errorMessage || message }}
                </div>
            </div>
        </aside>

        <!-- Right Preview Frame -->
        <section class="hidden lg:flex flex-1 h-full bg-[#e5e7eb] relative p-4 flex-col">
            <div class="w-full flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-black uppercase tracking-widest text-gray-500">Live Editor Sync</span>
                </div>
                <div class="text-[10px] font-bold text-gray-400 px-3 py-1 bg-white rounded shadow-sm border border-gray-200">
                    <i class="fas fa-desktop mr-1"></i> Desktop View Render
                </div>
            </div>
            
            <div class="flex-1 w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-300 relative transition-all duration-300 transform origin-top">
                <div v-if="isSyncing" class="absolute inset-0 bg-white/40 backdrop-blur-sm z-50 flex items-center justify-center pointer-events-none transition-opacity duration-300">
                    <div class="bg-white px-4 py-2 rounded-full shadow-lg border border-gray-100 flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-[#f28b11]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Compiling Assets...</span>
                    </div>
                </div>
                <!-- The Live Sandbox iframe -->
                <iframe ref="previewFrame" :src="`/templates/${form.template_key}/preview`" class="w-full h-full border-0"></iframe>
            </div>
        </section>
        
    </main>
  </div>
</template>

<script setup>
import { computed, reactive, ref, onMounted, watch } from 'vue';

const templateOptions = [
    { key: 'template_1', name: 'Neon Dark', style: 'Cyberpunk' },
    { key: 'template_2', name: 'Minimalist', style: 'Light' },
    { key: 'template_3', name: 'Creative', style: 'Gradients' },
    { key: 'template_4', name: 'Glassmorphism', style: 'Modern' },
    { key: 'template_5', name: 'Professional', style: 'Corporate' },
];

const message = ref('');
const errorMessage = ref('');
const downloading = ref(false);
const loadingFields = ref(false);
const isSyncing = ref(false);
const templateFieldsLayout = ref([]);
const previewFrame = ref(null);

const form = reactive({
  template_key: 'template_1',
  dynamic_fields: {},
  images: {}
});

// Computed properties to categorize fields
const uniqueSections = computed(() => {
    if (!templateFieldsLayout.value || templateFieldsLayout.value.length === 0) return [];
    const sections = new Set();
    templateFieldsLayout.value.forEach(f => {
        sections.add(f.section || 'General Settings');
    });
    return Array.from(sections);
});

const getFieldsBySection = (sectionName) => {
    return templateFieldsLayout.value.filter(f => (f.section || 'General Settings') === sectionName);
};

async function fetchTemplateFields() {
    loadingFields.value = true;
    try {
        const res = await fetch(`/api/templates/${form.template_key}/fields`);
        if (!res.ok) throw new Error('Fields not found');
        const data = await res.json();
        templateFieldsLayout.value = data.fields;
        
        // Initialize dynamic fields
        form.dynamic_fields = {};
        data.fields.forEach(f => {
            if (f.type === 'list') form.dynamic_fields[f.name] = f.default && Array.isArray(f.default) ? [...f.default] : [''];
            else if (f.type === 'projects') form.dynamic_fields[f.name] = f.default && Array.isArray(f.default) ? [...f.default] : [{ name: '', link: '', description: '' }];
            else form.dynamic_fields[f.name] = f.default || '';
        });
        
    } catch (e) {
        console.error("Failed to load fields", e);
    } finally {
        loadingFields.value = false;
        setTimeout(triggerLiveUpdate, 500); // Initial sync after load
    }
}

async function selectTemplate(key) {
    if (form.template_key === key) return;
    form.template_key = key;
    // The iframe src is bound to form.template_key, so it changes automatically
    // But we need to load the matching fields
    await fetchTemplateFields();
}

onMounted(() => {
    fetchTemplateFields();
});

// Live Preview Sync Logic
let debounceTimeout = null;

const triggerLiveUpdate = async () => {
    if(!previewFrame.value || !previewFrame.value.contentWindow) return;
    
    try {
        const payload = JSON.parse(JSON.stringify(form.dynamic_fields)); // Deep clone just in case
        
        const res = await fetch(`/templates/${form.template_key}/live-preview`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(payload)
        });
        
        if (res.ok) {
            const html = await res.text();
            previewFrame.value.contentWindow.postMessage({ html }, '*');
        }
    } catch(e) {
        console.error('Live Sync Error:', e);
    } finally {
        setTimeout(() => { isSyncing.value = false; }, 300);
    }
};

watch(() => form.dynamic_fields, () => {
    isSyncing.value = true;
    if (debounceTimeout) clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        triggerLiveUpdate();
    }, 600); // Wait 600ms after user stops typing before building HTML to prevent lag
}, { deep: true });

// Form Handlers
const addListItem = (fieldName) => {
    if (!form.dynamic_fields[fieldName]) form.dynamic_fields[fieldName] = [];
    form.dynamic_fields[fieldName].push('');
};
const removeListItem = (fieldName, i) => form.dynamic_fields[fieldName].splice(i, 1);

const addProject = (fieldName) => {
    if (!form.dynamic_fields[fieldName]) form.dynamic_fields[fieldName] = [];
    form.dynamic_fields[fieldName].push({ name: '', link: '', description: '' });
};
const removeProject = (fieldName, i) => form.dynamic_fields[fieldName].splice(i, 1);

async function generateAndDownload() {
  message.value = ''; errorMessage.value = ''; downloading.value = true;
  try {
    const payload = new FormData();
    payload.append('template_key', form.template_key);
    
    // Add dynamic fields
    Object.entries(form.dynamic_fields).forEach(([k, v]) => {
      if (Array.isArray(v) || typeof v === 'object') {
          payload.append(`dynamic_fields[${k}]`, JSON.stringify(v));
      } else {
          payload.append(`dynamic_fields[${k}]`, String(v ?? ''));
      }
    });

    const res = await fetch('/api/portfolios', { 
        method: 'POST', 
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }, 
        body: payload 
    });
    
    const data = await res.json();
    if (!res.ok) throw new Error(data.message || 'Validation failed');
    
    window.location.href = `/api/portfolios/${data.portfolio_id}/download`;
    message.value = 'Success! Stand by for download...';
  } catch (e) {
    errorMessage.value = e.message || 'Something went wrong';
  } finally {
    downloading.value = false;
  }
}
</script>
