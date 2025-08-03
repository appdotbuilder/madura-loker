import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    auth?: {
        user?: {
            name: string;
            role: string;
        };
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    return (
        <>
            <Head title="Loker Madura - Portal Lowongan Kerja Toko Kelontong" />
            
            <div className="min-h-screen bg-gradient-to-br from-orange-50 to-yellow-50">
                {/* Navigation */}
                <nav className="bg-white shadow-sm border-b border-orange-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-3">
                                <div className="text-2xl">🏪</div>
                                <h1 className="text-xl font-bold text-orange-800">Loker Madura</h1>
                            </div>
                            <div className="flex items-center space-x-4">
                                {auth?.user ? (
                                    <Link
                                        href="/dashboard"
                                        className="text-orange-700 hover:text-orange-900 font-medium"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <div className="flex space-x-2">
                                        <Link href="/login">
                                            <Button variant="outline" className="border-orange-300 text-orange-700 hover:bg-orange-50">
                                                Masuk
                                            </Button>
                                        </Link>
                                        <Link href="/register">
                                            <Button className="bg-orange-600 hover:bg-orange-700">
                                                Daftar
                                            </Button>
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Hero Section */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div className="text-center mb-16">
                        <div className="text-6xl mb-6">🛒🏪✨</div>
                        <h1 className="text-4xl md:text-6xl font-bold text-orange-900 mb-6">
                            Portal Lowongan Kerja
                            <br />
                            <span className="text-orange-600">Toko Kelontong Madura</span>
                        </h1>
                        <p className="text-xl text-orange-700 mb-8 max-w-3xl mx-auto">
                            Menghubungkan pemilik toko kelontong dengan pencari kerja di seluruh Madura. 
                            Temukan peluang kerja atau dapatkan karyawan terbaik untuk toko Anda!
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href="/jobs">
                                <Button size="lg" className="bg-orange-600 hover:bg-orange-700 text-lg px-8 py-3">
                                    🔍 Cari Lowongan Kerja
                                </Button>
                            </Link>
                            {!auth?.user && (
                                <Link href="/register">
                                    <Button size="lg" variant="outline" className="border-orange-300 text-orange-700 hover:bg-orange-50 text-lg px-8 py-3">
                                        📝 Daftar Sekarang
                                    </Button>
                                </Link>
                            )}
                        </div>
                    </div>

                    {/* Features Section */}
                    <div className="grid md:grid-cols-3 gap-8 mb-16">
                        <div className="bg-white rounded-2xl p-8 shadow-lg border border-orange-100">
                            <div className="text-4xl mb-4">👥</div>
                            <h3 className="text-xl font-bold text-orange-900 mb-3">Untuk Pencari Kerja</h3>
                            <ul className="text-orange-700 space-y-2">
                                <li>• Temukan lowongan kerja terbaru</li>
                                <li>• Lamar pekerjaan dengan mudah</li>
                                <li>• Pantau status lamaran Anda</li>
                                <li>• Profil lengkap dengan CV digital</li>
                            </ul>
                        </div>
                        
                        <div className="bg-white rounded-2xl p-8 shadow-lg border border-orange-100">
                            <div className="text-4xl mb-4">🏪</div>
                            <h3 className="text-xl font-bold text-orange-900 mb-3">Untuk Pemilik Toko</h3>
                            <ul className="text-orange-700 space-y-2">
                                <li>• Posting lowongan kerja gratis</li>
                                <li>• Kelola lamaran masuk</li>
                                <li>• Notifikasi WhatsApp otomatis</li>
                                <li>• Filter kandidat terbaik</li>
                            </ul>
                        </div>
                        
                        <div className="bg-white rounded-2xl p-8 shadow-lg border border-orange-100">
                            <div className="text-4xl mb-4">⚡</div>
                            <h3 className="text-xl font-bold text-orange-900 mb-3">Keunggulan Platform</h3>
                            <ul className="text-orange-700 space-y-2">
                                <li>• Khusus toko kelontong Madura</li>
                                <li>• Interface sederhana & mudah</li>
                                <li>• Notifikasi real-time</li>
                                <li>• Support lokal bahasa Madura</li>
                            </ul>
                        </div>
                    </div>

                    {/* Job Categories Preview */}
                    <div className="bg-white rounded-2xl p-8 shadow-lg border border-orange-100 mb-16">
                        <h2 className="text-2xl font-bold text-orange-900 mb-6 text-center">
                            🎯 Kategori Pekerjaan Tersedia
                        </h2>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                            {[
                                { icon: '🧮', name: 'Kasir' },
                                { icon: '👨‍💼', name: 'Pramuniaga' },
                                { icon: '👑', name: 'Supervisor' },
                                { icon: '📦', name: 'Admin Gudang' },
                                { icon: '🚛', name: 'Driver' },
                                { icon: '🧹', name: 'Cleaning Service' },
                                { icon: '🛡️', name: 'Security' },
                                { icon: '➕', name: 'Lainnya' },
                            ].map((category, index) => (
                                <div key={index} className="flex items-center space-x-2 p-3 rounded-lg bg-orange-50 hover:bg-orange-100 transition-colors">
                                    <span className="text-xl">{category.icon}</span>
                                    <span className="text-orange-800 font-medium">{category.name}</span>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Stats Section */}
                    <div className="grid md:grid-cols-4 gap-6 mb-16">
                        <div className="bg-orange-100 rounded-xl p-6 text-center">
                            <div className="text-3xl font-bold text-orange-800">500+</div>
                            <div className="text-orange-700">Lowongan Aktif</div>
                        </div>
                        <div className="bg-orange-100 rounded-xl p-6 text-center">
                            <div className="text-3xl font-bold text-orange-800">1000+</div>
                            <div className="text-orange-700">Pencari Kerja</div>
                        </div>
                        <div className="bg-orange-100 rounded-xl p-6 text-center">
                            <div className="text-3xl font-bold text-orange-800">200+</div>
                            <div className="text-orange-700">Toko Terdaftar</div>
                        </div>
                        <div className="bg-orange-100 rounded-xl p-6 text-center">
                            <div className="text-3xl font-bold text-orange-800">95%</div>
                            <div className="text-orange-700">Tingkat Kepuasan</div>
                        </div>
                    </div>

                    {/* How It Works */}
                    <div className="bg-gradient-to-r from-orange-600 to-yellow-600 rounded-2xl p-8 text-white mb-16">
                        <h2 className="text-3xl font-bold text-center mb-8">🚀 Cara Kerja Platform</h2>
                        <div className="grid md:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">1️⃣</span>
                                </div>
                                <h3 className="text-xl font-bold mb-2">Daftar Akun</h3>
                                <p>Buat akun sebagai pencari kerja atau pemilik toko kelontong</p>
                            </div>
                            <div className="text-center">
                                <div className="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">2️⃣</span>
                                </div>
                                <h3 className="text-xl font-bold mb-2">Posting/Cari Lowongan</h3>
                                <p>Posting lowongan kerja atau cari pekerjaan yang sesuai</p>
                            </div>
                            <div className="text-center">
                                <div className="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">3️⃣</span>
                                </div>
                                <h3 className="text-xl font-bold mb-2">Dapatkan Pekerjaan</h3>
                                <p>Terima notifikasi dan mulai bekerja di toko impian Anda</p>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    <div className="text-center">
                        <h2 className="text-3xl font-bold text-orange-900 mb-4">
                            🎉 Bergabunglah dengan Komunitas Loker Madura
                        </h2>
                        <p className="text-xl text-orange-700 mb-8">
                            Ribuan peluang kerja menanti Anda di toko-toko kelontong terbaik Madura
                        </p>
                        {!auth?.user && (
                            <Link href="/register">
                                <Button size="lg" className="bg-orange-600 hover:bg-orange-700 text-xl px-12 py-4">
                                    🚀 Mulai Sekarang - Gratis!
                                </Button>
                            </Link>
                        )}
                    </div>
                </div>

                {/* Footer */}
                <footer className="bg-orange-800 text-white py-12">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid md:grid-cols-4 gap-8">
                            <div>
                                <div className="flex items-center space-x-2 mb-4">
                                    <span className="text-2xl">🏪</span>
                                    <span className="text-xl font-bold">Loker Madura</span>
                                </div>
                                <p className="text-orange-200">
                                    Platform terpercaya untuk menghubungkan pemilik toko kelontong dengan pencari kerja di Madura.
                                </p>
                            </div>
                            <div>
                                <h3 className="font-bold mb-4">Untuk Pencari Kerja</h3>
                                <ul className="space-y-2 text-orange-200">
                                    <li><Link href="/jobs" className="hover:text-white">Cari Lowongan</Link></li>
                                    <li><Link href="/register" className="hover:text-white">Daftar Akun</Link></li>
                                    <li><Link href="/job-applications" className="hover:text-white">Riwayat Lamaran</Link></li>
                                </ul>
                            </div>
                            <div>
                                <h3 className="font-bold mb-4">Untuk Pemilik Toko</h3>
                                <ul className="space-y-2 text-orange-200">
                                    <li><Link href="/jobs/create" className="hover:text-white">Posting Lowongan</Link></li>
                                    <li><Link href="/my-jobs" className="hover:text-white">Kelola Lowongan</Link></li>
                                    <li><Link href="/register" className="hover:text-white">Daftar Toko</Link></li>
                                </ul>
                            </div>
                            <div>
                                <h3 className="font-bold mb-4">Kontak</h3>
                                <ul className="space-y-2 text-orange-200">
                                    <li>📞 0813-3456-7890</li>
                                    <li>📧 info@lokermadura.com</li>
                                    <li>📍 Pamekasan, Madura</li>
                                </ul>
                            </div>
                        </div>
                        <div className="border-t border-orange-700 mt-8 pt-8 text-center text-orange-200">
                            <p>&copy; 2024 Loker Madura. Semua hak cipta dilindungi.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}