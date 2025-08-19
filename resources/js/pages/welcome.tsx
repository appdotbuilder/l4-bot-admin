import React from 'react';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface Props {
    stats: {
        total_buyers: number;
        active_buyers: number;
        banned_buyers: number;
        total_sellers: number;
        active_sellers: number;
        banned_sellers: number;
        total_numbers: number;
        available_numbers: number;
        rented_numbers: number;
        pending_invoices: number;
        total_revenue: number;
        monthly_revenue: number;
    };
    recent_buyers: Array<{
        id: number;
        display_name: string;
        telegram_id: string;
        status: string;
        balance: number;
        total_numbers_used: number;
        last_activity: string;
    }>;
    recent_invoices: Array<{
        id: number;
        invoice_number: string;
        total_amount: number;
        status: string;
        buyer: {
            display_name: string;
        };
    }>;
    [key: string]: unknown;
}

export default function Welcome({ stats, recent_buyers, recent_invoices }: Props) {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="📞 Telegram Bot Admin Panel">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                <header className="bg-white shadow-sm dark:bg-gray-800">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center py-6">
                            <div className="flex items-center space-x-3">
                                <div className="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-lg">
                                    <span className="text-2xl">📞</span>
                                </div>
                                <div>
                                    <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                        Telegram Bot Admin Panel
                                    </h1>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        Number Rental System Management
                                    </p>
                                </div>
                            </div>
                            <nav className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <div className="flex space-x-3">
                                        <Link
                                            href={route('login')}
                                            className="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors dark:text-gray-300 dark:hover:text-white"
                                        >
                                            Log in
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                                        >
                                            Register
                                        </Link>
                                    </div>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    {/* Hero Section */}
                    <div className="text-center mb-16">
                        <h2 className="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            Complete Number Rental Management
                        </h2>
                        <p className="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                            Efficiently manage your Telegram bot's phone number rental system with comprehensive 
                            tools for buyers, sellers, billing, and analytics.
                        </p>
                    </div>

                    {/* Stats Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Buyers</p>
                                    <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_buyers}</p>
                                </div>
                                <div className="bg-blue-100 p-3 rounded-lg dark:bg-blue-900">
                                    <span className="text-xl">👥</span>
                                </div>
                            </div>
                            <p className="text-sm text-green-600 dark:text-green-400 mt-2">
                                {stats.active_buyers} active, {stats.banned_buyers} banned
                            </p>
                        </div>

                        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sellers</p>
                                    <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_sellers}</p>
                                </div>
                                <div className="bg-green-100 p-3 rounded-lg dark:bg-green-900">
                                    <span className="text-xl">🏪</span>
                                </div>
                            </div>
                            <p className="text-sm text-green-600 dark:text-green-400 mt-2">
                                {stats.active_sellers} active, {stats.banned_sellers} banned
                            </p>
                        </div>

                        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Phone Numbers</p>
                                    <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_numbers}</p>
                                </div>
                                <div className="bg-purple-100 p-3 rounded-lg dark:bg-purple-900">
                                    <span className="text-xl">📱</span>
                                </div>
                            </div>
                            <p className="text-sm text-green-600 dark:text-green-400 mt-2">
                                {stats.available_numbers} available, {stats.rented_numbers} rented
                            </p>
                        </div>

                        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Revenue</p>
                                    <p className="text-3xl font-bold text-gray-900 dark:text-white">${stats.monthly_revenue}</p>
                                </div>
                                <div className="bg-yellow-100 p-3 rounded-lg dark:bg-yellow-900">
                                    <span className="text-xl">💰</span>
                                </div>
                            </div>
                            <p className="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                ${stats.total_revenue} total revenue
                            </p>
                        </div>
                    </div>

                    {/* Features Grid */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                        <div className="bg-white rounded-xl shadow-sm p-8 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center space-x-3 mb-4">
                                <div className="bg-blue-100 p-2 rounded-lg dark:bg-blue-900">
                                    <span className="text-lg">👥</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white">Buyer Management</h3>
                            </div>
                            <ul className="space-y-2 text-gray-600 dark:text-gray-300">
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>View and edit buyer profiles</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Ban/unban buyers instantly</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Stop all active numbers for buyers</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Track usage and payment history</span>
                                </li>
                            </ul>
                        </div>

                        <div className="bg-white rounded-xl shadow-sm p-8 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center space-x-3 mb-4">
                                <div className="bg-green-100 p-2 rounded-lg dark:bg-green-900">
                                    <span className="text-lg">🏪</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white">Seller Management</h3>
                            </div>
                            <ul className="space-y-2 text-gray-600 dark:text-gray-300">
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Manage seller accounts</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Set commission rates</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Track seller performance</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Monitor number inventory</span>
                                </li>
                            </ul>
                        </div>

                        <div className="bg-white rounded-xl shadow-sm p-8 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center space-x-3 mb-4">
                                <div className="bg-purple-100 p-2 rounded-lg dark:bg-purple-900">
                                    <span className="text-lg">📱</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white">Number Management</h3>
                            </div>
                            <ul className="space-y-2 text-gray-600 dark:text-gray-300">
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>View all phone numbers</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Filter by country and status</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Edit number details</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Track SMS codes received</span>
                                </li>
                            </ul>
                        </div>

                        <div className="bg-white rounded-xl shadow-sm p-8 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center space-x-3 mb-4">
                                <div className="bg-yellow-100 p-2 rounded-lg dark:bg-yellow-900">
                                    <span className="text-lg">💰</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white">Billing & Payments</h3>
                            </div>
                            <ul className="space-y-2 text-gray-600 dark:text-gray-300">
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Generate daily billing invoices</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Track buyer payments</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Monitor pending invoices</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <span className="text-green-500">✓</span>
                                    <span>Revenue analytics</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {/* Recent Activity */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div className="bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">Recent Buyers</h3>
                            </div>
                            <div className="p-6">
                                {recent_buyers && recent_buyers.length > 0 ? (
                                    <div className="space-y-4">
                                        {recent_buyers.map((buyer) => (
                                            <div key={buyer.id} className="flex items-center justify-between">
                                                <div>
                                                    <p className="font-medium text-gray-900 dark:text-white">
                                                        {buyer.display_name}
                                                    </p>
                                                    <p className="text-sm text-gray-500 dark:text-gray-400">
                                                        {buyer.total_numbers_used} numbers used
                                                    </p>
                                                </div>
                                                <div className="text-right">
                                                    <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                                                        buyer.status === 'active' 
                                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                    }`}>
                                                        {buyer.status}
                                                    </span>
                                                    <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                        ${buyer.balance}
                                                    </p>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-gray-500 dark:text-gray-400 text-center py-8">
                                        No buyer data available
                                    </p>
                                )}
                            </div>
                        </div>

                        <div className="bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">Pending Invoices</h3>
                            </div>
                            <div className="p-6">
                                {recent_invoices && recent_invoices.length > 0 ? (
                                    <div className="space-y-4">
                                        {recent_invoices.map((invoice) => (
                                            <div key={invoice.id} className="flex items-center justify-between">
                                                <div>
                                                    <p className="font-medium text-gray-900 dark:text-white">
                                                        {invoice.invoice_number}
                                                    </p>
                                                    <p className="text-sm text-gray-500 dark:text-gray-400">
                                                        {invoice.buyer.display_name}
                                                    </p>
                                                </div>
                                                <div className="text-right">
                                                    <p className="font-semibold text-gray-900 dark:text-white">
                                                        ${invoice.total_amount}
                                                    </p>
                                                    <span className="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        {invoice.status}
                                                    </span>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-gray-500 dark:text-gray-400 text-center py-8">
                                        No pending invoices
                                    </p>
                                )}
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    <div className="text-center mt-16">
                        {!auth.user && (
                            <div className="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white">
                                <h3 className="text-2xl font-bold mb-4">Ready to Get Started?</h3>
                                <p className="text-lg mb-6 opacity-90">
                                    Join thousands of administrators managing their Telegram bot systems efficiently.
                                </p>
                                <div className="flex justify-center space-x-4">
                                    <Link
                                        href={route('register')}
                                        className="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors"
                                    >
                                        Get Started
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition-colors"
                                    >
                                        Sign In
                                    </Link>
                                </div>
                            </div>
                        )}
                    </div>
                </main>

                <footer className="bg-white border-t border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div className="text-center">
                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                Built with ❤️ by{" "}
                                <a 
                                    href="https://app.build" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    className="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                                >
                                    app.build
                                </a>
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}