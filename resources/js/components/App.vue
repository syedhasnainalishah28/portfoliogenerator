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
            <!-- Step 1: Basic Info -->
            <div v-show="currentStep === 1" class="space-y-5 animate-fadeIn">
            <div class="border-b border-gray-100 pb-4 mb-4">
                <h3 class="text-lg font-bold">Personal Information</h3>
                <p class="text-xs text-[#5e5963]">Your core identity details.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="ha-label">Full Name</label><input v-model="form.full_name" class="ha-input" placeholder="e.g. John Doe" /></div>
                <div><label class="ha-label">Professional Title</label><input v-model="form.title" class="ha-input" placeholder="e.g. Frontend Developer" /></div>
                <div><label class="ha-label">Email Address</label><input v-model="form.email" type="email" class="ha-input" placeholder="john@example.com" /></div>
                <div><label class="ha-label">WhatsApp Link</label><input v-model="form.whatsapp_link" class="ha-input" placeholder="https://wa.me/..." /></div>
            </div>
            
            <div>
                <label class="ha-label">About You (Bio)</label>
                <textarea v-model="form.bio" class="ha-input min-h-[120px] resize-y" placeholder="Write a short, impactful professional summary..."></textarea>
            </div>
            
            <div class="p-5 rounded-xl border border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center gap-3">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-gray-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="text-center">
                    <label class="text-[#f28b11] font-semibold text-sm cursor-pointer hover:underline">
                        Upload Hero Image
                        <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.webp" @change="selectImage" />
                    </label>
                    <p class="text-xs text-[#9ca3af] mt-1">Recommended size: 800x800px (JPG/PNG/WEBP)</p>
                </div>
            </div>
            </div>

            <!-- Step 2: Template & Theme -->
            <div v-show="currentStep === 2" class="space-y-5 animate-fadeIn">
            <div class="border-b border-gray-100 pb-4 mb-4">
                <h3 class="text-lg font-bold">Design & Theme</h3>
                <p class="text-xs text-[#5e5963]">Choose your aesthetic structure.</p>
            </div>
            
            <div>
                <label class="ha-label mb-3">Layout Template</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <button v-for="template in templateOptions" :key="template.key" type="button"
                        class="relative group rounded-2xl border-2 transition-all overflow-hidden text-left"
                        :class="form.template_key === template.key ? 'border-primary ring-4 ring-primary/10' : 'border-gray-100 hover:border-gray-200'"
                        @click="form.template_key = template.key">
                        
                        <!-- Visual representation of template -->
                        <div class="aspect-video w-full relative flex items-center justify-center overflow-hidden" :class="template.previewBg">
                            <div v-if="template.key === 'template_1'" class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-pink-500/20 backdrop-blur-sm"></div>
                            <div v-if="template.key === 'template_3'" class="absolute inset-0 bg-black flex flex-col items-center justify-center border border-primary/20">
                                <div class="w-12 h-1 bg-primary/40 animate-pulse"></div>
                            </div>
                            <div v-if="template.key === 'template_5'" class="absolute bottom-0 right-0 w-1/2 h-full bg-primary/10 transform skew-x-12"></div>
                            
                            <span class="relative z-10 text-[10px] uppercase tracking-widest font-black opacity-40">{{ template.style }}</span>
                        </div>

                        <div class="p-4 bg-white">
                            <h4 class="font-bold text-sm">{{ template.name }}</h4>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">{{ template.desc }}</p>
                        </div>

                        <!-- Checkmark -->
                        <div v-if="form.template_key === template.key" class="absolute top-3 right-3 w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center shadow-lg transform scale-110">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="ha-label">Primary Color</label>
                    <div class="flex items-center gap-3">
                        <input v-model="form.primary_color" type="color" class="w-10 h-10 rounded-lg cursor-pointer border border-gray-200" />
                        <span class="text-sm font-mono text-[#5e5963] uppercase">{{ form.primary_color }}</span>
                    </div>
                </div>
            </div>
            
            <div class="pt-2">
                <label class="ha-label flex justify-between">
                    Hero Image Size
                    <span class="text-[#f28b11] font-bold">{{ form.hero_image_size }}px</span>
                </label>
                <input v-model="form.hero_image_size" type="range" min="220" max="520" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#f28b11]" />
                <div class="flex justify-between text-xs text-[#9ca3af] mt-1"><span>220px</span><span>520px</span></div>
            </div>
            </div>

            <!-- Step 3: Skills & Projects -->
            <div v-show="currentStep === 3" class="space-y-8 animate-fadeIn">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <div>
                        <h3 class="text-lg font-bold">Skills</h3>
                        <p class="text-xs text-[#5e5963]">Add tags for your expertise.</p>
                    </div>
                    <button class="text-sm font-semibold text-[#f28b11] hover:text-[#e07a00] flex items-center gap-1 bg-orange-50 px-3 py-1.5 rounded-lg" type="button" @click="addSkill">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add
                    </button>
                </div>
                
                <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                    <div v-for="(_, i) in form.skills" :key="`skill-${i}`" class="relative group w-full sm:w-[calc(50%-0.6rem)]">
                        <input v-model="form.skills[i]" class="ha-input pr-10" :placeholder="`e.g. React.js`" />
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors p-1" type="button" title="Remove" @click="removeSkill(i)">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4 mt-6 sm:mt-0">
                    <div>
                        <h3 class="text-lg font-bold">Projects</h3>
                        <p class="text-xs text-[#5e5963]">Showcase your best work.</p>
                    </div>
                    <button class="text-sm font-semibold text-[#f28b11] hover:text-[#e07a00] flex items-center gap-1 bg-orange-50 px-3 py-1.5 rounded-lg" type="button" @click="addProject">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div v-for="(project, i) in form.projects" :key="`project-${i}`" class="rounded-xl border border-gray-200 bg-gray-50/50 p-4 sm:p-5 relative group transition-all hover:border-[#f2b311]/50 focus-within:border-[#f2b311] focus-within:ring-1 focus-within:ring-[#f2b311]/20">
                        <button v-if="form.projects.length > 1" class="absolute right-2 top-2 sm:-right-2 sm:-top-2 bg-white rounded-full w-6 h-6 flex items-center justify-center shadow-md text-gray-400 hover:text-red-500 border border-gray-100 z-10" type="button" title="Remove Project" @click="removeProject(i)">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <div class="space-y-3">
                            <div><label class="ha-label text-[11px] sm:text-xs">Project Title</label><input v-model="project.name" class="ha-input bg-white border-transparent shadow-sm" placeholder="e.g. E-commerce App" /></div>
                            <div><label class="ha-label text-[11px] sm:text-xs">Live Link / Repo</label><input v-model="project.link" class="ha-input bg-white border-transparent shadow-sm" placeholder="https://..." /></div>
                            <div><label class="ha-label text-[11px] sm:text-xs">Description</label><textarea v-model="project.description" class="ha-input bg-white border-transparent shadow-sm min-h-[80px]" placeholder="Built with Vue & Tailwind..."></textarea></div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <h2 class="text-sm font-bold text-[#1e1b20] truncate">Live Preview</h2>
                    <p class="text-[9px] sm:text-[10px] text-[#9ca3af] uppercase tracking-wider truncate">{{ activeTemplate.name }}</p>
                </div>
                <div class="flex gap-1.5 shrink-0">
                    <div class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-red-400"></div>
                    <div class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-yellow-400"></div>
                    <div class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-green-400"></div>
                </div>
            </div>
            
            <!-- Mini Document Preview -->
            <div class="p-4 sm:p-6 bg-white min-h-[400px] w-full overflow-hidden flex flex-col items-center">
                <div class="w-full flex justify-center mb-5 sm:mb-6 shrink-0">
                    <div v-if="imagePreview" class="relative">
                        <img :src="imagePreview" class="rounded-2xl object-cover shadow-lg w-[120px] h-[120px] sm:w-[140px] sm:h-[140px]" alt="Hero preview" />
                        <div class="absolute inset-0 rounded-2xl ring-2 ring-white shadow-inner pointer-events-none"></div>
                    </div>
                    <div v-else class="w-[120px] h-[120px] sm:w-[140px] sm:h-[140px] rounded-2xl bg-gray-100 border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-[10px] sm:text-xs">
                        No Image
                    </div>
                </div>
                
                <div class="text-center space-y-2 w-full">
                    <h3 class="text-lg sm:text-2xl font-extrabold text-[#1e1b20] break-words w-full px-2 leading-tight">{{ form.full_name || 'Your Full Name' }}</h3>
                    <p class="font-semibold text-xs sm:text-sm break-words w-full px-2" :style="{ color: form.primary_color }">{{ form.title || 'Professional Title' }}</p>
                </div>
                
                <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-100 w-full">
                    <p class="text-[10px] sm:text-xs text-[#5e5963] leading-relaxed text-center italic break-words w-full px-2">
                        {{ form.bio ? (form.bio.length > 120 ? form.bio.substring(0, 120) + '...' : form.bio) : 'Your bio preview will appear here. Write a compelling summary about your professional journey.' }}
                    </p>
                </div>
                
                <div class="mt-auto pt-6 flex w-full justify-center gap-2">
                    <div class="w-1/3 h-1 bg-gray-100 rounded-full"></div>
                    <div class="w-16 h-1 bg-gray-200 rounded-full"></div>
                </div>
            </div>
        </div>
      </aside>
    </main>
  </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';

const steps = [{ id: 1, title: 'Basic Info' }, { id: 2, title: 'Template & Color' }, { id: 3, title: 'Skills & Projects' }];
const templateOptions = [
    { key: 'template_1', name: 'Premium Glass', style: 'Glassmorphism', desc: 'Modern & Translucent', previewBg: 'bg-slate-900' },
    { key: 'template_2', name: 'Minimalist', style: 'Clean & Pure', desc: 'Focus on content', previewBg: 'bg-white border-b' },
    { key: 'template_3', name: 'Cyberpunk', style: 'High Tech', desc: 'Neon & Dark', previewBg: 'bg-black' },
    { key: 'template_4', name: 'Corporate', style: 'Professional', desc: 'Elite Business Look', previewBg: 'bg-slate-50' },
    { key: 'template_5', name: 'Creative', style: 'Bold & Artistic', desc: 'Experimental Layouts', previewBg: 'bg-gray-100' },
];
const currentStep = ref(1);
const message = ref('');
const errorMessage = ref('');
const downloading = ref(false);
const imagePreview = ref('');

const form = reactive({
  full_name: '', title: '', bio: '', email: '', phone: '', whatsapp_link: '', template_key: 'template_1',
  primary_color: '#CC9F63', secondary_color: '#1E0907', background_color: '#FFFFFF', font_family: 'Inter',
  hero_image_size: 320, hero_image: null, skills: [''], projects: [{ name: '', description: '', link: '' }],
});

const activeTemplate = computed(() => templateOptions.find((t) => t.key === form.template_key) || templateOptions[0]);
const nextStep = () => { if (currentStep.value < 3) currentStep.value += 1; };
const prevStep = () => { if (currentStep.value > 1) currentStep.value -= 1; };
const addSkill = () => form.skills.push('');
const removeSkill = (i) => form.skills.splice(i, 1);
const addProject = () => form.projects.push({ name: '', description: '', link: '' });
const removeProject = (i) => form.projects.splice(i, 1);

function selectImage(e) {
  const file = e.target.files?.[0];
  form.hero_image = file || null;
  imagePreview.value = file ? URL.createObjectURL(file) : '';
}

async function generateAndDownload() {
  message.value = ''; errorMessage.value = ''; downloading.value = true;
  try {
    const payload = new FormData();
    Object.entries(form).forEach(([k, v]) => {
      if (k === 'skills' || k === 'projects') payload.append(k, JSON.stringify(v));
      else if (k === 'hero_image' && v) payload.append(k, v);
      else if (k !== 'hero_image') payload.append(k, String(v ?? ''));
    });
    const res = await fetch('/api/portfolios', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }, body: payload });
    const data = await res.json();
    if (!res.ok) {
      if (data.errors) {
        const firstError = Object.values(data.errors)[0][0];
        throw new Error(firstError);
      }
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
