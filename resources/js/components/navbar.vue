<template>
    <nav class="navbar">
        <div class="navbar__container">
            <div class="navbar__brand">
                Bramming Tanker
            </div>
            <div class="navbar__links">
                <a 
                v-for="route in routes" 
                :key="route.path"
                :href="route.path" 
                class="navbar__link"
                :class="{ 'navbar__link--active': isActive(route.path) }"
                >
                {{ route.name }}
            </a>
            <a href="/logout" class="navbar__link navbar__link--logout">
                Log ud
            </a>
        </div>
    </div>
</nav>
</template>

<script>
export default {
    data() {
        return {
            routes: [
            { name: 'Elever', path: '/students' },
            { name: 'Profil', path: '/profile' },
            ]
        }
    },
    methods: {
        isActive(path) {
            return window.location.pathname.startsWith(path);
        }
    }
}
</script>

<style lang="scss" scoped>
// SCSS Variables
$primary-color: #4361ee;
$secondary-color: #3a0ca3;
$accent-color: #f72585;
$gradient-start: #4cc9f0;
$gradient-end: #4361ee;
$text-color: #2b2d42;
$light-bg: #ffffff;
$card-bg: #f8f9fa;
$border-color: #e9ecef;
$shadow-color: rgba(0, 0, 0, 0.1);
$shadow-hover: rgba(67, 97, 238, 0.25);
$border-radius-sm: 10px;
$border-radius-lg: 16px;
$spacing-xs: 0.5rem;
$spacing-sm: 1rem;
$spacing-md: 1.5rem;
$spacing-lg: 2rem;
$spacing-xl: 3rem;
$breakpoint-sm: 576px;
$breakpoint-md: 768px;
$breakpoint-lg: 992px;
$breakpoint-xl: 1200px;
$transition-fast: 0.2s;
$transition-med: 0.3s;

.navbar {
    background: linear-gradient(to right, $primary-color, $secondary-color);
    padding: $spacing-sm 0;
    box-shadow: 0 2px 10px rgba($secondary-color, 0.3);
    margin-bottom: $spacing-lg;
    
    &__container {
        width: 100%;
        max-width: $breakpoint-lg;
        margin: 0 auto;
        padding: 0 $spacing-md;
        display: flex;
        justify-content: space-between;
        
        @media (max-width: $breakpoint-md) {
            flex-direction: column;
            gap: $spacing-sm;
        }
    }
    
    &__brand {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    &__links {
        display: flex;
        gap: $spacing-md;
        
        @media (max-width: $breakpoint-sm) {
            gap: $spacing-sm;
        }
    }
    
    &__link {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 500;
        transition: all $transition-fast;
        position: relative;
        padding: $spacing-xs $spacing-sm;
        border-radius: $border-radius-sm;
        
        &::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 70%;
            height: 2px;
            background-color: white;
            transition: transform $transition-med;
        }
        
        &:hover {
            color: white;
            
            &::after {
                transform: translateX(-50%) scaleX(1);
            }
        }
        
        &--active {
            color: white;
            
            &::after {
                transform: translateX(-50%) scaleX(1);
            }
        }
        
        &--logout {
            background-color: rgba(white, 0.15);
            padding: $spacing-xs $spacing-sm;
            border-radius: $border-radius-sm;
            
            &:hover {
                background-color: rgba(white, 0.25);
            }
            
            &::after {
                display: none;
            }
        }
    }
}
</style>