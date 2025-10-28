<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Hero Section -->
    <flux:spacer />
    <div class="text-center">
        <flux:heading size="2xl">Welcome to the Blog</flux:heading>
        <flux:subheading size="lg" class="mb-8">Your one-stop destination for all things blogging.</flux:subheading>
        <div class="flex justify-center gap-4">
            <flux:button href="#features" variant="primary">Explore Features</flux:button>
            <flux:button href="#posts" variant="outline">Read Posts</flux:button>
        </div>
    </div>
    <flux:spacer />

    <!-- Features Section -->
    <flux:spacer />
    <div id="features" class="bg-white dark:bg-gray-800 py-16">
        <div class="max-w-6xl mx-auto px-6">
            <flux:heading size="xl" class="text-center mb-12">Features</flux:heading>
            <div class="grid md:grid-cols-3 gap-8">
                <flux:card>
                    <div class="text-center">
                        <flux:icon name="plus" class="w-16 h-16 mx-auto mb-4 text-blue-600" />
                        <flux:heading size="md" class="mb-2">Easy to Use</flux:heading>
                        <flux:subheading size="sm">Our platform is designed for simplicity and ease of use.</flux:subheading>
                    </div>
                </flux:card>
                <!-- Add more feature cards here if needed -->
            </div>
        </div>
    </div>
    <flux:spacer />

    <!-- Posts Section -->
    <flux:spacer />
    <div id="posts" class="bg-gray-50 dark:bg-gray-900 py-16">
        <div class="max-w-4xl mx-auto px-6">
            <flux:heading size="xl" class="text-center mb-6">Latest Posts</flux:heading>
            <div class="space-y-4">
                <flux:card>
                    <flux:heading size="md">Post 1</flux:heading>
                    <flux:subheading size="sm">Brief description of post 1.</flux:subheading>
                </flux:card>
                <flux:card>
                    <flux:heading size="md">Post 2</flux:heading>
                    <flux:subheading size="sm">Brief description of post 2.</flux:subheading>
                </flux:card>
                <flux:card>
                    <flux:heading size="md">Post 3</flux:heading>
                    <flux:subheading size="sm">Brief description of post 3.</flux:subheading>
                </flux:card>
            </div>
        </div>
    </div>
    <flux:spacer />

    <!-- Newsletter Section -->
    <flux:spacer />
    <div class="bg-blue-600 text-white py-16">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <flux:heading size="xl" class="mb-4">Subscribe to our Newsletter</flux:heading>
            <flux:subheading size="lg" class="mb-8">Stay updated with the latest posts and features.</flux:subheading>
            <form class="flex justify-center gap-4">
                <flux:input type="email" placeholder="Enter your email" required />
                <flux:button type="submit" variant="outline">Subscribe</flux:button>
            </form>
        </div>
    </div>
    <flux:spacer />
</div>