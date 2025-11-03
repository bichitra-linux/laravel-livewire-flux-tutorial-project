<x-blog-header title="Terms" />

<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="prose dark:prose-invert max-w-none">
        <h1 class="text-4xl font-bold mb-6 text-gray-900 dark:text-white">Terms of Service</h1>
        
        <p class="text-gray-600 dark:text-gray-400 mb-8">Last updated: {{ now()->format('F d, Y') }}</p>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">1. Acceptance of Terms</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                By accessing and using {{ config('app.name') }}, you accept and agree to be bound by the terms and provision of this agreement.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">2. User Accounts</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                When you create an account with us, you must provide accurate, complete, and current information. 
                Failure to do so constitutes a breach of the Terms.
            </p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>You are responsible for safeguarding your password</li>
                <li>You must not share your account credentials</li>
                <li>You must notify us immediately of any unauthorized access</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">3. Content</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                Our service allows you to post, link, store, share and otherwise make available certain information. 
                You are responsible for the content that you post.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">4. Prohibited Uses</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">You may not use our service:</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>In any way that violates any applicable law or regulation</li>
                <li>To transmit any malicious code or malware</li>
                <li>To harass, abuse, or harm another person</li>
                <li>To spam or send unsolicited messages</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">5. Contact Us</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                If you have any questions about these Terms, please contact us at 
                <a href="mailto:{{ config('mail.from.address') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ config('mail.from.address') }}
                </a>
            </p>
        </section>
    </div>
</div>

<x-footer />