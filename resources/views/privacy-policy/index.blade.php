<x-blog-header title="Privacy" />

<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="prose dark:prose-invert max-w-none">
        <h1 class="text-4xl font-bold mb-6 text-gray-900 dark:text-white">Privacy Policy</h1>
        
        <p class="text-gray-600 dark:text-gray-400 mb-8">Last updated: {{ now()->format('F d, Y') }}</p>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">1. Information We Collect</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                We collect information that you provide directly to us:
            </p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>Account information (name, email, password)</li>
                <li>Profile information</li>
                <li>Posts and comments you create</li>
                <li>Newsletter subscriptions</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">2. How We Use Your Information</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                We use the information we collect to:
            </p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>Provide, maintain, and improve our services</li>
                <li>Send you technical notices and support messages</li>
                <li>Respond to your comments and questions</li>
                <li>Send you newsletters (if you opted in)</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">3. Information Sharing</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                We do not share your personal information with third parties except as described in this policy.
                We may share information in response to legal requests or to protect our rights.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">4. Cookies</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                We use cookies and similar technologies to provide and support our services.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">5. Your Rights</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">You have the right to:</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>Access your personal information</li>
                <li>Correct inaccurate information</li>
                <li>Request deletion of your information</li>
                <li>Opt-out of marketing communications</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">6. Contact Us</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                If you have any questions about this Privacy Policy, please contact us at 
                <a href="mailto:{{ config('mail.from.address') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ config('mail.from.address') }}
                </a>
            </p>
        </section>
    </div>
</div>

<x-footer />