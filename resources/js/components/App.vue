<template>
  <div class="min-h-screen bg-[#f0f2f5] text-[#1e1b20] overflow-x-hidden w-full pb-10">
    <header class="bg-white border-b border-[#e5e7eb] sticky top-0 z-10 glass-nav">
      <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center gap-2 sm:gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#f28b11] to-[#f2b311] flex flex-col items-center justify-center text-white font-bold text-sm shadow-md">H</div>
            <div>
                <p class="text-sm sm:text-xl font-extrabold tracking-tight">Generator</p>
                <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-[0.2em] text-[#f28b11]">VVIP Portal</p>
            </div>
        </div>
        <a href="/dashboard" class="ha-btn-secondary px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-[#5e5963] flex items-center gap-1 sm:gap-2">
            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span class="hidden sm:inline">Exit to Dashboard</span>
            <span class="sm:hidden">Exit</span>
        </a>
      </div>
    </header>

    <main class="mx-auto grid max-w-7xl gap-6 px-4 py-8 lg:gap-8 lg:px-6 lg:py-10 lg:grid-cols-12 lg:items-start min-w-0 w-full overflow-hidden">
      
      <!-- Wizard Form -->
      <section class="lg:col-span-7 xl:col-span-8 flex flex-col gap-5 lg:gap-6 min-w-0 w-full max-w-full">
        
        <div class="mb-2 lg:mb-4 px-1">
            <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight">Create Identity</h1>
            <p class="text-sm lg:text-base text-[#5e5963] mt-1">Configure your personal portfolio details below.</p>
        </div>
        
        <!-- Premium Step Indicator -->
        <div class="flex items-center gap-2 lg:gap-3 overflow-x-auto pb-4 hide-scrollbar snap-x w-full">
            <button v-for="(step, idx) in steps" :key="step.id" type="button" 
                class="flex shrink-0 items-center gap-2 lg:gap-3 px-3 py-2 lg:px-4 lg:py-2.5 rounded-xl border font-semibold text-xs lg:text-sm transition-all whitespace-nowrap snap-start"
                :class="currentStep === step.id ? 'border-[#f28b11] bg-orange-50 text-[#f28b11] shadow-sm' : 'border-gray-200 bg-white text-[#9ca3af] hover:border-gray-300 hover:text-[#5e5963]'" 
                @click="currentStep = step.id">
                <span class="w-5 h-5 lg:w-6 lg:h-6 rounded-full flex items-center justify-center text-[10px] lg:text-xs font-bold shrink-0" 
                    :class="currentStep === step.id ? 'bg-[#f28b11] text-white' : 'bg-gray-100 text-gray-400'">
                    {{ idx + 1 }}
                </span>
                <span>{{ step.title }}</span>
            </button>
        </div>

        <div class="ha-card p-4 sm:p-8 shadow-sm w-full max-w-full overflow-hidden">
            <!-- Step 1: Select Template -->
            <div v-show="currentStep === 1" class="space-y-5 animate-fadeIn">
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-lg font-bold">Design & Theme</h3>
                    <p class="text-xs text-[#5e5963]">Choose your aesthetic structure.</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="template in templateOptions" :key="template.key" 
                        class="relative group rounded-2xl border-2 transition-all overflow-hidden flex flex-col"
                        :class="form.template_key === template.key ? 'border-primary ring-4 ring-primary/10' : 'border-gray-100'">
                        
                        <button type="button" class="w-full text-left" @click="selectTemplate(template.key)">
                            <div class="aspect-video w-full relative flex items-center justify-center overflow-hidden" :class="template.previewBg">
                                <span class="relative z-10 text-[10px] uppercase tracking-widest font-black opacity-40 text-gray-400">{{ template.style }}</span>
                            </div>
                            <div class="p-4 bg-white">
                                <h4 class="font-bold text-sm">{{ template.name }}</h4>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">{{ template.desc }}</p>
                            </div>
                        </button>
                        
                        <!-- Actions -->
                        <div class="p-2 border-t border-gray-100 bg-gray-50 flex gap-2">
                            <button type="button" @click="selectTemplate(template.key)" class="flex-1 py-1.5 text-xs font-bold rounded-lg transition-colors" :class="form.template_key === template.key ? 'bg-primary text-white' : 'bg-white border hover:bg-gray-100'">
                                {{ form.template_key === template.key ? 'Selected' : 'Select' }}
                            </button>
                            <a :href="`/templates/${template.key}/preview`" target="_blank" class="py-1.5 px-3 bg-white border border-gray-200 hover:bg-gray-100 rounded-lg text-xs font-bold text-gray-600 flex items-center justify-center">
                                Preview <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                        
                        <!-- Checkmark -->
                        <div v-if="form.template_key === template.key" class="absolute top-3 right-3 w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center shadow-lg transform scale-110 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Content (Dynamically generated from fields.json) -->
            <div v-show="currentStep === 2" class="space-y-5 animate-fadeIn">
                <div class="border-b border-gray-100 pb-4 mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Content & Branding</h3>
                        <p class="text-xs text-[#5e5963]">Fill out the details for {{ activeTemplate.name }}.</p>
                    </div>
                </div>

                <div v-if="loadingFields" class="py-10 text-center text-gray-400">Loading template fields...</div>
                
                <div v-else class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <template v-for="field in textFields" :key="field.name">
                            <div v-if="field.type === 'text' || field.type === 'email' || field.type === 'number' || field.type === 'url' || field.type === 'color'">
                                <label class="ha-label">{{ field.label }}</label>
                                <div v-if="field.type === 'color'" class="flex items-center gap-3">
                                    <input v-model="form.dynamic_fields[field.name]" type="color" class="w-10 h-10 rounded-lg cursor-pointer border border-gray-200" />
                                    <span class="text-sm font-mono text-[#5e5963] uppercase">{{ form.dynamic_fields[field.name] }}</span>
                                </div>
                                <input v-else v-model="form.dynamic_fields[field.name]" :type="field.type" class="ha-input" :placeholder="`e.g. ${field.default || ''}`" />
                            </div>
                        </template>
                    </div>

                    <template v-for="field in textareaFields" :key="field.name">
                        <div>
                            <label class="ha-label">{{ field.label }}</label>
                            <textarea v-model="form.dynamic_fields[field.name]" class="ha-input min-h-[100px] resize-y" :placeholder="field.default"></textarea>
                        </div>
                    </template>
                    
                    <template v-for="field in imageFields" :key="field.name">
                        <div class="p-5 rounded-xl border border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center gap-3">
                            <div class="text-center">
                                <label class="text-[#f28b11] font-semibold text-sm cursor-pointer hover:underline">
                                    Upload {{ field.label }}
                                    <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.webp" @change="e => selectDynamicImage(e, field.name)" />
                                </label>
                                <p class="text-xs text-[#9ca3af] mt-1" v-if="form.dynamic_fields[field.name]">Image selected</p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Step 3: Complex Lists (Skills/Projects) -->
            <div v-show="currentStep === 3" class="space-y-8 animate-fadeIn">
                <template v-for="field in listFields" :key="field.name">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                            <div>
                                <h3 class="text-lg font-bold">{{ field.label }}</h3>
                            </div>
                            <button class="text-sm font-semibold text-[#f28b11] hover:text-[#e07a00] flex items-center gap-1 bg-orange-50 px-3 py-1.5 rounded-lg" type="button" @click="addListItem(field.name)">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add
                            </button>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                            <div v-for="(_, i) in form.dynamic_fields[field.name]" :key="`list-${field.name}-${i}`" class="relative group w-full sm:w-[calc(50%-0.6rem)]">
                                <input v-model="form.dynamic_fields[field.name][i]" class="ha-input pr-10" placeholder="Value" />
                                <button class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors p-1" type="button" title="Remove" @click="removeListItem(field.name, i)">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-for="field in projectFields" :key="field.name">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4 mt-6">
                            <div>
                                <h3 class="text-lg font-bold">{{ field.label }}</h3>
                            </div>
                            <button class="text-sm font-semibold text-[#f28b11] hover:text-[#e07a00] flex items-center gap-1 bg-orange-50 px-3 py-1.5 rounded-lg" type="button" @click="addProject(field.name)">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div v-for="(project, i) in form.dynamic_fields[field.name]" :key="`proj-${field.name}-${i}`" class="rounded-xl border border-gray-200 bg-gray-50/50 p-4 sm:p-5 relative group">
                                <button class="absolute right-2 top-2 bg-white rounded-full w-6 h-6 flex items-center justify-center shadow-md text-gray-400 hover:text-red-500 border border-gray-100" type="button" title="Remove" @click="removeProject(field.name, i)">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <div class="space-y-3">
                                    <div><label class="ha-label">Project Title</label><input v-model="project.name" class="ha-input bg-white border-transparent shadow-sm" /></div>
                                    <div><label class="ha-label">Link</label><input v-model="project.link" class="ha-input bg-white border-transparent shadow-sm" /></div>
                                    <div><label class="ha-label">Description</label><textarea v-model="project.description" class="ha-input bg-white border-transparent shadow-sm min-h-[60px]"></textarea></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Actions -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                <div>
                    <button v-if="currentStep > 1" class="ha-btn-secondary px-5 py-2.5 text-sm" @click="prevStep">Back</button>
                </div>
                <div>
                    <button v-if="currentStep < 3" class="ha-btn px-6 py-2.5 text-sm" @click="nextStep">Continue <svg class="w-4 h-4 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></button>
                    <button v-if="currentStep === 3" class="ha-btn px-8 py-2.5 text-sm shadow-lg shadow-maroon/20 font-bold" :disabled="downloading" @click="generateAndDownload">
                        <span v-if="downloading" class="flex items-center gap-2">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Building Zip...
                        </span>
                        <span v-else>Generate & Download</span>
                    </button>
                </div>
            </div>
            
            <div v-if="message || errorMessage" class="mt-4 p-3 rounded-lg text-sm font-medium text-center" :class="errorMessage ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-emerald-700 border border-green-100'">
                {{ errorMessage || message }}
            </div>
            
        </div>
      </section>

      <!-- Live Preview Sidebar -->
      <aside class="lg:col-span-5 xl:col-span-4 sticky top-28 w-full max-w-full">
        <div class="ha-card overflow-hidden shadow-xl shadow-maroon/5 flex flex-col h-full border border-[#e5e7eb] w-full max-w-full">
            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between gap-2 overflow-hidden">
                <div class="min-w-0 flex-1">
                    <h2 class="text-sm font-bold text-[#1e1b20] truncate">Current Template</h2>
                    <p class="text-[9px] sm:text-[10px] text-[#9ca3af] uppercase tracking-wider truncate">{{ activeTemplate.name }}</p>
                </div>
            </div>
            <div class="p-6 text-center space-y-4">
                <p class="text-sm text-gray-500">Live preview reflects your exact content mapped to the {{ activeTemplate.name }} design structure.</p>
                <div class="text-xs text-gray-400 bg-gray-50 rounded-lg p-3">{{ String(form.dynamic_fields.full_name || 'Name goes here') }}</div>
            </div>
        </div>
      </aside>
    </main>
  </div>
</template>

<script setup>
import { computed, reactive, ref, onMounted } from 'vue';

const steps = [{ id: 1, title: 'Select Template' }, { id: 2, title: 'Identity Content' }, { id: 3, title: 'Lists & Projects' }];
const templateOptions = [
    { key: 'template_1', name: 'Neon Dark', style: 'Cyberpunk', desc: 'Bold, colorful cyberpunk', previewBg: 'bg-slate-900 border-none' },
    { key: 'template_2', name: 'Minimalist', style: 'Elegant Light', desc: 'Clean, distraction-free', previewBg: 'bg-white border-b border-gray-200' },
    { key: 'template_3', name: 'Creative Gradient', style: 'High Tech', desc: 'Bold & Colorful', previewBg: 'bg-black border-none' },
    { key: 'template_4', name: 'Glassmorphism', style: 'Professional', desc: 'Deep Purple & Orbs', previewBg: 'bg-[#0D0B1E] border-none' },
    { key: 'template_5', name: 'Professional Light', style: 'Sidebar Corporate', desc: 'Clean sidebar layout', previewBg: 'bg-slate-50 border-none' },
];

const currentStep = ref(1);
const message = ref('');
const errorMessage = ref('');
const downloading = ref(false);
const loadingFields = ref(false);
const templateFieldsLayout = ref([]);

const form = reactive({
  template_key: 'template_1',
  dynamic_fields: {},
  images: {}
});

const activeTemplate = computed(() => templateOptions.find((t) => t.key === form.template_key) || templateOptions[0]);

// Computed properties to categorize fields for rendering
const textFields = computed(() => templateFieldsLayout.value.filter(f => ['text', 'email', 'url', 'number', 'color'].includes(f.type)));
const textareaFields = computed(() => templateFieldsLayout.value.filter(f => f.type === 'textarea'));
const listFields = computed(() => templateFieldsLayout.value.filter(f => f.type === 'list'));
const projectFields = computed(() => templateFieldsLayout.value.filter(f => f.type === 'projects'));
const imageFields = computed(() => templateFieldsLayout.value.filter(f => f.type === 'image'));

async function selectTemplate(key) {
    if (form.template_key === key && templateFieldsLayout.value.length > 0) return;
    form.template_key = key;
    await fetchTemplateFields();
}

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
    }
}

onMounted(() => {
    fetchTemplateFields();
});

const nextStep = () => { if (currentStep.value < 3) currentStep.value += 1; };
const prevStep = () => { if (currentStep.value > 1) currentStep.value -= 1; };

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

function selectDynamicImage(e, fieldName) {
    const file = e.target.files?.[0];
    if (file) {
        form.images[fieldName] = file;
        form.dynamic_fields[fieldName] = 'uploaded'; // marking as present
    }
}

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

    // Add images
    Object.entries(form.images).forEach(([k, file]) => {
        if (file) payload.append(`images[${k}]`, file);
    });

    const res = await fetch('/api/portfolios', { 
        method: 'POST', 
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }, 
        body: payload 
    });
    
    const data = await res.json();
    if (!res.ok) {
        throw new Error(data.message || 'Validation failed');
    }
    
    window.location.href = `/api/portfolios/${data.portfolio_id}/download`;
    message.value = 'Portfolio generated. Download starting...';
  } catch (e) {
    errorMessage.value = e.message || 'Something went wrong';
  } finally {
    downloading.value = false;
  }
}
</script>
