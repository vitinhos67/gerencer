<template>
    <div>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 font-weight-bold mb-6">
                    Configurações do Sistema
                </h1>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12" md="6">
                <v-card elevation="2">
                    <v-card-title>
                        Configurações Gerais
                    </v-card-title>
                    <v-card-text>
                        <v-form>
                            <v-text-field
                                v-model="settings.siteName"
                                label="Nome do Site"
                                class="mb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="settings.siteUrl"
                                label="URL do Site"
                                class="mb-4"
                            ></v-text-field>
                            <v-textarea
                                v-model="settings.description"
                                label="Descrição do Site"
                                rows="3"
                                class="mb-4"
                            ></v-textarea>
                            <v-switch
                                v-model="settings.maintenanceMode"
                                label="Modo de Manutenção"
                                color="warning"
                            ></v-switch>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            @click="saveGeneralSettings"
                        >
                            Salvar Configurações
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card elevation="2">
                    <v-card-title>
                        Configurações de Email
                    </v-card-title>
                    <v-card-text>
                        <v-form>
                            <v-text-field
                                v-model="emailSettings.smtpHost"
                                label="Servidor SMTP"
                                class="mb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="emailSettings.smtpPort"
                                label="Porta SMTP"
                                type="number"
                                class="mb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="emailSettings.smtpUser"
                                label="Usuário SMTP"
                                class="mb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="emailSettings.smtpPassword"
                                label="Senha SMTP"
                                type="password"
                                class="mb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="emailSettings.fromEmail"
                                label="Email Remetente"
                                type="email"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            @click="saveEmailSettings"
                        >
                            Salvar Configurações
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-row class="mt-6">
            <v-col cols="12">
                <v-card elevation="2">
                    <v-card-title>
                        Configurações de Segurança
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-switch
                                    v-model="securitySettings.twoFactorAuth"
                                    label="Autenticação de Dois Fatores"
                                    color="primary"
                                    class="mb-4"
                                ></v-switch>
                                <v-switch
                                    v-model="securitySettings.passwordExpiration"
                                    label="Expiração de Senha"
                                    color="primary"
                                    class="mb-4"
                                ></v-switch>
                                <v-text-field
                                    v-model="securitySettings.sessionTimeout"
                                    label="Tempo de Sessão (minutos)"
                                    type="number"
                                    class="mb-4"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-switch
                                    v-model="securitySettings.ipWhitelist"
                                    label="Lista Branca de IPs"
                                    color="primary"
                                    class="mb-4"
                                ></v-switch>
                                <v-switch
                                    v-model="securitySettings.auditLog"
                                    label="Log de Auditoria"
                                    color="primary"
                                    class="mb-4"
                                ></v-switch>
                                <v-text-field
                                    v-model="securitySettings.maxLoginAttempts"
                                    label="Tentativas Máximas de Login"
                                    type="number"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            @click="saveSecuritySettings"
                        >
                            Salvar Configurações
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

interface GeneralSettings {
    siteName: string
    siteUrl: string
    description: string
    maintenanceMode: boolean
}

interface EmailSettings {
    smtpHost: string
    smtpPort: string
    smtpUser: string
    smtpPassword: string
    fromEmail: string
}

interface SecuritySettings {
    twoFactorAuth: boolean
    passwordExpiration: boolean
    sessionTimeout: string
    ipWhitelist: boolean
    auditLog: boolean
    maxLoginAttempts: string
}

export default defineComponent({
    name: 'SettingsComponent',
    data() {
        return {
            settings: {
                siteName: 'Gerenciador',
                siteUrl: 'https://gerenciador.com',
                description: 'Sistema de gerenciamento administrativo',
                maintenanceMode: false
            } as GeneralSettings,
            emailSettings: {
                smtpHost: 'smtp.gmail.com',
                smtpPort: '587',
                smtpUser: '',
                smtpPassword: '',
                fromEmail: 'noreply@gerenciador.com'
            } as EmailSettings,
            securitySettings: {
                twoFactorAuth: true,
                passwordExpiration: false,
                sessionTimeout: '30',
                ipWhitelist: false,
                auditLog: true,
                maxLoginAttempts: '5'
            } as SecuritySettings
        }
    },
    methods: {
        saveGeneralSettings() {
            // Implementar salvamento das configurações gerais
            console.log('Salvando configurações gerais:', this.settings)
        },
        saveEmailSettings() {
            // Implementar salvamento das configurações de email
            console.log('Salvando configurações de email:', this.emailSettings)
        },
        saveSecuritySettings() {
            // Implementar salvamento das configurações de segurança
            console.log('Salvando configurações de segurança:', this.securitySettings)
        }
    }
})
</script> 